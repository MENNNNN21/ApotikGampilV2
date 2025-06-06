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
    public function pay(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('obat')->get();
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout.validasi')->with('error', 'Mohon lengkapi validasi pengiriman terlebih dahulu.');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

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

        $orderId = 'APT-' . $user->id . '-' . time();

        $transaksi = Transaksi::create([
            'id' => $orderId,
            'user_id' => $user->id,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'pending',
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

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

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pembayaran', ['snapToken' => $snapToken, 'transaksi' => $transaksi]);
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function notificationHandler(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new Notification();
            $notif->getResponse();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            Log::info("Notifikasi Midtrans Diterima - Order ID: {$order_id}, Status: {$transaction}");

            $transaksi = Transaksi::find($order_id);

            if ($transaksi) {
                if (in_array($transaction, ['capture', 'settlement'])) {
                    if ($fraud === 'accept') {
                        $transaksi->status_pembayaran = 'dibayar';
                        Cart::where('user_id', $transaksi->user_id)->delete();
                    } else {
                        $transaksi->status_pembayaran = 'pending';
                    }
                } else if ($transaction === 'pending') {
                    $transaksi->status_pembayaran = 'pending';
                } else if (in_array($transaction, ['deny', 'cancel', 'expire'])) {
                    $transaksi->status_pembayaran = 'pending'; // Bisa tambahkan kolom 'status_midtrans' jika mau detail
                }

                $transaksi->save();
                return response()->json(['message' => 'Notification processed.'], 200);
            } else {
                Log::error("Transaksi tidak ditemukan untuk Order ID: {$order_id}");
                return response()->json(['message' => 'Transaction not found.'], 404);
            }

        } catch (\Exception $e) {
            Log::error("Error Verifikasi Notifikasi Midtrans: " . $e->getMessage());
            return response()->json(['message' => 'Invalid notification: ' . $e->getMessage()], 403);
        }
    }

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
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'pengiriman' => 'required|in:antar,ambil',
        ]);

        session([
            'checkout_data' => [
                'nama_penerima' => $request->nama_penerima,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'pengiriman' => $request->pengiriman,
            ]
        ]);

        return redirect()->route('checkout.pay');
    }

    // ✅ Fungsi untuk menandai transaksi selesai (manual)
   // public function tandaiSelesai($id)
   // {
     //   $transaksi = Transaksi::findOrFail($id);

       // if ($transaksi->status_pembayaran === 'dibayar') {
         //   $transaksi->status_pembayaran = 'selesai';
           // $transaksi->save();

            // return back()->with('success', 'Transaksi ditandai sebagai selesai.');
       // }

        //return back()->with('error', 'Transaksi belum dibayar atau sudah selesai.');
   // }
}
