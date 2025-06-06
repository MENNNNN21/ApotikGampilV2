<?php
// file: app/Http/Controllers/BiteshipController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cart; // Tambahkan model Cart
use Illuminate\Support\Facades\Auth; // Tambahkan Auth

class BiteshipController extends Controller
{
    /**
     * Mengambil estimasi ongkos kirim dari API Biteship.
     */
    public function getRates(Request $request)
    {
        $request->validate([
            'destination_area_id' => 'required|string',
        ]);

        // Hitung total berat dari keranjang belanja user
        $cartItems = Cart::where('user_id', Auth::id())->with('obat')->get();
        $totalWeight = 0;
        foreach ($cartItems as $item) {
            // Asumsi setiap obat punya berat 0.1 kg (100 gram).
            // Idealnya, Anda punya kolom 'berat' di tabel obats.
            $weightPerItem = $item->obat->berat ?? 0.1; 
            $totalWeight += $weightPerItem * $item->jumlah;
        }

        // Biteship mengharapkan berat dalam gram
        $totalWeightInGrams = max(1, $totalWeight) * 1000;

        // Ambil data pengirim dari config
        $shipper = config('biteship.shipper');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('biteship.api_key'),
        ])->post(config('biteship.base_url') . '/v1/rates/couriers', [
            'origin_area_id' => $shipper['area_id'],
            'destination_area_id' => $request->destination_area_id,
            'couriers' => 'sicepat,jne,anteraja', // Kurir yang ingin ditampilkan
            'items' => [
                [
                    'name' => 'Produk Kesehatan',
                    'description' => 'Paket dari Apotik Gampil',
                    'value' => 100000, // Nilai default untuk asuransi
                    'weight' => $totalWeightInGrams,
                    'quantity' => 1,
                ]
            ]
        ]);

        if ($response->successful() && $response->json()['success']) {
            return response()->json($response->json());
        }

        return response()->json(['success' => false, 'error' => 'Gagal mengambil data ongkir.'], 500);
    }
}