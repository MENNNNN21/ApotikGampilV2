@extends('layouts.app')

@section('title', $obat->nama)

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Gambar Obat --}}
        <div class="col-md-6 text-center">
            <img src="{{ asset('storage/' . $obat->gambar) }}" alt="{{ $obat->nama }}" class="img-fluid rounded" style="max-height: 400px;">
        </div>

        {{-- Detail Obat --}}
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $obat->nama }}</h2>

            <p class="text-muted mt-2 mb-3">
                <i class="fas fa-check-circle text-success me-1"></i> Produk Ini Tidak Kedaluwarsa
            </p>

            <h4 class="text-primary fw-semibold">Rp {{ number_format($obat->harga, 0, ',', '.') }}</h4>

            <p class="mt-4">{{ $obat->deskripsi }}</p>

            {{-- Form Tambah ke Keranjang --}}
            <form action="{{ route('produk.addToCart', $obat->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3 d-flex align-items-center">
                    <label for="jumlah" class="me-3">Jumlah:</label>
                    <div class="input-group" style="width: 120px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="ubahJumlah(-1)">-</button>
                        <input type="number" name="jumlah" id="jumlah" class="form-control text-center" value="1" min="1">
                        <button type="button" class="btn btn-outline-secondary" onclick="ubahJumlah(1)">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning fw-bold px-4">
                    <i class="fas fa-cart-plus me-2"></i> Masukkan ke Keranjang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function ubahJumlah(delta) {
        const input = document.getElementById('jumlah');
        let nilai = parseInt(input.value);
        if (!isNaN(nilai)) {
            nilai = Math.max(1, nilai + delta);
            input.value = nilai;
        }
    }
</script>
@endsection
