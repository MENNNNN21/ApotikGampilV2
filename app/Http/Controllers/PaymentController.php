<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaksi;
use App\Models\Cart;
use Illuminate\Support\Str;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function validasi()
    {
        $user = Auth::user();
        $cartItems = Cart::with('obat')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('validasi_checkout', compact('user', 'cartItems'));
    }

    public function simpanValidasi(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama_penerima' => 'required|string|max:100',
                'telepon' => 'required|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'pengiriman' => 'required|in:antar,ambil',
            ]);

            // Debug log
            Log::info('Data validasi checkout berhasil:', $validatedData);

            // Simpan data ke session
            session([
                'checkout_data' => $validatedData
            ]);

            // Debug: cek apakah session tersimpan
            Log::info('Session checkout_data:', session('checkout_data'));

            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.pay')->with('success', 'Data validasi berhasil disimpan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return back()
                   ->withErrors($e->validator)
                   ->withInput()
                   ->with('error', 'Ada kesalahan dalam pengisian form');
        } catch (\Exception $e) {
            Log::error('Error di simpanValidasi: ' . $e->getMessage());
            return back()
                   ->withInput()
                   ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function pay(Request $request)
    {
        try {
            // 1. Cek data checkout di session
            $checkoutData = session('checkout_data');
            if (!$checkoutData) {
                return redirect()->route('checkout.validasi')
                               ->with('error', 'Mohon lengkapi validasi pengiriman terlebih dahulu.');
            }

            // 2. Ambil data keranjang user
            $user = Auth::user();
            $cartItems = Cart::where('user_id', $user->id)->with('obat')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
            }

            // 3. Hitung total & siapkan item details
            $totalHarga = 0;
            $item_details = [];

            foreach ($cartItems as $item) {
                if ($item->obat) {
                    $totalHarga += $item->obat->harga * $item->jumlah;
                    $item_details[] = [
                        'id' => $item->obat->id,
                        'price' => $item->obat->harga,
                        'quantity' => $item->jumlah,
                        'name' => Str::limit($item->obat->nama, 50),
                    ];
                }
            }

            // 4. Buat record transaksi baru di database
            $orderId = 'APT-' . $user->id . '-' . time();
            $transaksi = Transaksi::create([
                'id' => $orderId,
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'status_pembayaran' => 'pending',
                'nama_penerima' => $checkoutData['nama_penerima'],
                'telepon' => $checkoutData['telepon'],
                'alamat' => $checkoutData['alamat'],
                'pengiriman' => $checkoutData['pengiriman'],
            ]);

            // 5. Simpan detail transaksi (opsional, tergantung struktur DB)
            foreach ($cartItems as $item) {
                if ($item->obat) {
                    // Jika ada tabel detail_transaksi
                    // $transaksi->detailTransaksi()->create([...]);
                }
            }

            // 6. Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // 7. Siapkan Parameter untuk Midtrans Snap
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalHarga,
                ],
                'item_details' => $item_details,
                'customer_details' => [
                    'first_name' => $checkoutData['nama_penerima'],
                    'email' => $user->email,
                    'phone' => $checkoutData['telepon'],
                ],
            ];

            // 8. Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // 9. Hapus data checkout dari session setelah berhasil
            session()->forget('checkout_data');

            // 10. Kembalikan view dengan Snap Token
            return view('pembayaran', [
                'snapToken' => $snapToken, 
                'transaksi' => $transaksi,
                'totalHarga' => $totalHarga
            ]);

        } catch (\Exception $e) {
            Log::error('Error di method pay: ' . $e->getMessage());
            return redirect()->route('checkout.validasi')
                           ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function notificationHandler(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);

        try {
            $notif = new Notification();
            $transaction = $notif->transaction_status;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            Log::info("Notifikasi Midtrans - Order ID: {$order_id}, Status: {$transaction}");

            $transaksi = Transaksi::find($order_id);

            if ($transaksi) {
                if ($transaction == 'capture' || $transaction == 'settlement') {
                    if ($fraud == 'challenge') {
                        $transaksi->status_pembayaran = 'challenge';
                    } else if ($fraud == 'accept') {
                        $transaksi->status_pembayaran = 'lunas';
                        // Kosongkan keranjang user
                        Cart::where('user_id', $transaksi->user_id)->delete();
                    }
                } else if ($transaction == 'pending') {
                    $transaksi->status_pembayaran = 'pending';
                } else if ($transaction == 'deny') {
                    $transaksi->status_pembayaran = 'ditolak';
                } else if ($transaction == 'expire') {
                    $transaksi->status_pembayaran = 'kadaluarsa';
                } else if ($transaction == 'cancel') {
                    $transaksi->status_pembayaran = 'dibatalkan';
                }

                $transaksi->save();
                return response()->json(['message' => 'Notification processed.'], 200);
            } else {
                Log::error("Transaksi tidak ditemukan untuk Order ID: {$order_id}");
                return response()->json(['message' => 'Transaction not found.'], 404);
            }

        } catch (\Exception $e) {
            Log::error("Error Notifikasi Midtrans: " . $e->getMessage());
            return response()->json(['message' => 'Invalid notification: ' . $e->getMessage()], 403);
        }
    }
}