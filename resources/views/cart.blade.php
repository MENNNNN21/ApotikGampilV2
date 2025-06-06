@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
{{-- Header dengan gradient modern --}}
<div class="mb-4 text-white p-4 rounded-3 position-relative shadow" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <a href="{{ url('/produk') }}" class="btn btn-light btn-sm position-absolute start-0 top-50 translate-middle-y ms-3 rounded-circle shadow-sm">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="mb-0 text-center fw-bold">
        <i class="fas fa-shopping-cart me-2"></i>
        Keranjang Belanja
    </h4>
</div>

<div class="container py-4">
    {{-- Alert dengan styling modern --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($cartItems) === 0)
        {{-- Empty cart dengan ilustrasi --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
            <h5 class="text-muted mb-3">Keranjang Anda Kosong</h5>
            <p class="text-muted mb-4">Yuk, mulai berbelanja dan temukan produk favorit Anda!</p>
            <a href="{{ url('/produk') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                <i class="fas fa-store me-2"></i>
                Mulai Belanja
            </a>
        </div>
    @else
        {{-- Cart items dengan card design --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-list me-2"></i>
                            Item Keranjang ({{ count($cartItems) }} produk)
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php
                                if ($item->obat) {
                                    $subtotal = $item->obat->harga * $item->jumlah;
                                    $total += $subtotal;
                                } else {
                                    $subtotal = 0;
                                }
                            @endphp
                            <div class="border-bottom p-4 {{ $loop->last ? 'border-bottom-0' : '' }}">
                                <div class="row align-items-center">
                                    {{-- Product Image & Name --}}
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            @if ($item->obat)
                                                <div class="me-3">
                                                    <img src="{{ asset('storage/' . $item->obat->gambar) }}" 
                                                         alt="{{ $item->obat->nama }}" 
                                                         class="rounded-3 shadow-sm" 
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $item->obat->nama }}</h6>
                                                    <p class="text-muted small mb-0">
                                                        <span class="badge bg-light text-dark">
                                                            Rp {{ number_format($item->obat->harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>
                                            @else
                                                <div class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    Produk Tidak Tersedia
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Quantity Controls --}}
                                    <div class="col-md-3">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-sort-numeric-up-alt"></i>
                                                </span>
                                                <input type="number" 
                                                       name="jumlah" 
                                                       class="form-control border-start-0 text-center" 
                                                       value="{{ $item->jumlah }}" 
                                                       min="1" 
                                                       onchange="this.form.submit()">
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="mb-0 fw-bold text-primary">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </h6>
                                            <small class="text-muted">Subtotal</small>
                                        </div>
                                    </div>

                                    {{-- Delete Button --}}
                                    <div class="col-md-1">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" 
                                              onsubmit="return confirm('Hapus item ini dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm rounded-circle">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-calculator me-2"></i>
                            Ringkasan Pesanan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Item:</span>
                            <span class="fw-bold">{{ count($cartItems) }} produk</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <h6 class="mb-0">Total Pembayaran:</h6>
                            <h5 class="mb-0 fw-bold text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h5>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.validasi') }}" 
                               class="btn btn-success py-3 rounded-3 fw-bold">
                                <i class="fas fa-credit-card me-2"></i>
                                Lanjut ke Checkout
                            </a>
                            <a href="{{ url('/produk') }}" 
                               class="btn btn-outline-primary rounded-3">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Produk Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Custom CSS untuk animasi dan enhancement --}}
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: scale(1.02);
}

.input-group-sm .form-control {
    font-weight: 600;
}

.sticky-top {
    z-index: 1020;
}

@media (max-width: 768px) {
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
}
</style>

@endsection