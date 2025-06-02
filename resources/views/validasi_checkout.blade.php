@extends('layouts.app')

@section('title', 'Validasi Pengiriman')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold">Validasi Pengiriman</h4>

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan pesan sukses/error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.simpanValidasi') }}" method="POST" id="checkout-form">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Metode Pengambilan</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pengiriman" value="antar" 
                       {{ old('pengiriman', 'antar') == 'antar' ? 'checked' : '' }}>
                <label class="form-check-label">Dikirim</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pengiriman" value="ambil"
                       {{ old('pengiriman') == 'ambil' ? 'checked' : '' }}>
                <label class="form-check-label">Ambil ke Tempat</label>
            </div>
            @error('pengiriman')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
            <input type="text" name="nama_penerima" class="form-control @error('nama_penerima') is-invalid @enderror" 
                   value="{{ old('nama_penerima', $user->name ?? '') }}" required>
            @error('nama_penerima')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                   value="{{ old('telepon', $user->telepon ?? '') }}" required>
            @error('telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                      rows="3">{{ old('alamat', $user->alamat ?? '') }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <h5 class="fw-bold">Daftar Produk</h5>
        @if(isset($cartItems) && $cartItems->count() > 0)
            @foreach ($cartItems as $item)
                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                    <div>
                        <strong>{{ $item->obat->nama ?? 'Produk tidak ditemukan' }}</strong><br>
                        <small>Harga: Rp {{ number_format($item->obat->harga ?? 0, 0, ',', '.') }}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center me-2">
                            @csrf
                            @method('PUT')
                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" 
                                   class="form-control form-control-sm me-2" min="1" style="width: 70px"
                                   onchange="this.form.submit()">
                        </form>
                        <a href="{{ route('cart.destroy', $item->id) }}" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Hapus item ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                    <i class="fas fa-check"></i> Lanjut ke Pembayaran
                </button>
            </div>
        @else
            <div class="alert alert-warning">
                Keranjang belanja kosong. <a href="{{ route('obat.index') }}">Belanja sekarang</a>
            </div>
        @endif
    </form>
</div>

<script>
// Tambahkan loading state pada tombol submit
document.getElementById('checkout-form').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
});

// Debug: log saat form disubmit
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    console.log('Form disubmit');
    console.log('Action:', this.action);
    console.log('Method:', this.method);
});
</script>
@endsection