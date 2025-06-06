@extends('layouts.app')

@section('title', 'Validasi Checkout')

@section('content')
<div class="mb-4 text-white p-3 rounded position-relative shadow-sm" style="background-color: #A0E9FF">
    <a href="{{ route('cart.index') }}" class="btn btn-light btn-sm position-absolute start-0 top-50 translate-middle-y ms-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h5 class="mb-0 text-center fw-bold text-black">Validasi Checkout</h5>
</div>

<div class="container py-4">
    {{-- Alert untuk error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tampilkan ringkasan pesanan --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Ringkasan Pesanan</h6>
        </div>
        <div class="card-body">
            @php $total = 0; @endphp
            @foreach($cartItems as $item)
                @if($item->obat)
                    @php
                        $subtotal = $item->obat->harga * $item->jumlah;
                        $total += $subtotal;
                    @endphp
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $item->obat->gambar) }}" alt="{{ $item->obat->nama }}" width="50" class="me-3">
                            <div>
                                <strong>{{ $item->obat->nama }}</strong>
                                <small class="text-muted d-block">{{ $item->jumlah }} x Rp {{ number_format($item->obat->harga, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                @endif
            @endforeach
            <div class="d-flex justify-content-between align-items-center pt-2">
                <strong>Total:</strong>
                <strong class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    {{-- Form Validasi --}}
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-user-check me-2"></i>Informasi Pengiriman</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('checkout.simpan-validasi') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nama_penerima" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" 
                           id="nama_penerima" name="nama_penerima" 
                           value="{{ old('nama_penerima', $user->name) }}" required>
                    @error('nama_penerima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" name="telepon" 
                           value="{{ old('telepon', $user->no_hp) }}" 
                           placeholder="08xxxxxxxxxx" required>
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pengiriman" class="form-label">Metode Pengiriman <span class="text-danger">*</span></label>
                    <select class="form-select @error('pengiriman') is-invalid @enderror" id="pengiriman" name="pengiriman" required>
                        <option value="">Pilih metode pengiriman</option>
                        <option value="antar" {{ old('pengiriman') == 'antar' ? 'selected' : '' }}>Antar ke Alamat</option>
                        <option value="ambil" {{ old('pengiriman') == 'ambil' ? 'selected' : '' }}>Ambil di Apotek</option>
                    </select>
                    @error('pengiriman')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="alamat-field" style="display: none;">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="3" 
                              placeholder="Masukkan alamat lengkap untuk pengiriman">{{ old('alamat', $user->alamat) }}</textarea>
                    <small class="text-muted">Alamat diperlukan jika memilih "Antar ke Alamat"</small>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Keranjang
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-check me-1"></i> Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk show/hide alamat --}}
<script>
document.getElementById('pengiriman').addEventListener('change', function() {
    const alamatField = document.getElementById('alamat-field');
    if (this.value === 'antar') {
        alamatField.style.display = 'block';
        document.getElementById('alamat').required = true;
    } else {
        alamatField.style.display = 'none';
        document.getElementById('alamat').required = false;
    }
});

// Trigger on page load if old value exists
if (document.getElementById('pengiriman').value === 'antar') {
    document.getElementById('alamat-field').style.display = 'block';
    document.getElementById('alamat').required = true;
}
</script>
@endsection