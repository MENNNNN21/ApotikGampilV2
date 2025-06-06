// file: config/biteship.php

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kredensial API Biteship
    |--------------------------------------------------------------------------
    | Ambil nilai ini dari file .env Anda.
    | Jangan pernah menulis API Key secara langsung di sini.
    */
    'api_key' => env('BITESHIP_API_KEY'),

    'base_url' => env('BITESHIP_BASE_URL', 'https://api.biteship.com'),

    /*
    |--------------------------------------------------------------------------
    | Info Pengirim Default
    |--------------------------------------------------------------------------
    | Informasi ini akan digunakan sebagai data asal pengiriman (shipper).
    | Sesuaikan dengan informasi apotek Anda.
    */
    'shipper' => [
        'name' => 'Apotik Gampil',
        'phone' => '081234567890', // Ganti dengan no telepon apotek
        'address' => 'Jalan Cihampelas No. 123, Bandung', // Ganti dengan alamat apotek
        'postal_code' => '40131', // Ganti dengan kode pos apotek
        
        // Penting: Dapatkan ID area ini dari API Biteship atau hubungi support mereka.
        // ID ini mewakili lokasi kecamatan/kelurahan asal pengiriman.
        // Contoh untuk Cihampelas, Bandung
        'area_id' => 'ID3273180',
    ],
];