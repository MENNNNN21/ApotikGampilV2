@extends('admin.layout') {{-- Sesuaikan dengan nama layout admin Anda --}}

@section('title', 'Detail Transaksi - ' . $transaksi->id)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi: {{ $transaksi->id }}</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID Transaksi:</strong> {{ $transaksi->id }}</p>
                    <p><strong>Nama Pelanggan:</strong> {{ $transaksi->user->name ?? 'N/A' }}</p>
                    <p><strong>Email Pelanggan:</strong> {{ $transaksi->user->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d M Y, H:i:s') }}</p>
                    <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong>
                         <span class="badge bg-primary">{{ ucfirst($transaksi->status_pembayaran) }}</span>
                         {{-- Bisa gunakan logika badge yang sama seperti di index --}}
                    </p>
                </div>
            </div>
            <hr>
            <h5>Item yang Dibeli:</h5>
            {{-- Di sini Anda perlu memuat dan menampilkan item transaksi --}}
            {{-- Contoh jika Anda punya relasi 'items' --}}
            {{--
            <ul class="list-group">
                @forelse($transaksi->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->obat->nama }} ({{ $item->jumlah }} x Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }})
                        <span>Rp {{ number_format($item->jumlah * $item->harga_saat_transaksi, 0, ',', '.') }}</span>
                    </li>
                @empty
                    <li class="list-group-item">Detail item tidak ditemukan.</li>
                @endforelse
            </ul>
            --}}
            <p class="text-muted">(Fitur detail item belum diimplementasikan sepenuhnya)</p>

            {{-- Tambahkan bagian untuk update status jika perlu --}}
        </div>
    </div>
</div>
@endsection