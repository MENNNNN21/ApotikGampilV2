@if($obats->count() > 0)
    <div class="row">
        @foreach($obats as $obat)
            <div class="col-md-4 mb-3"> {{-- Sesuaikan grid (col-md-4, col-lg-3, dll) --}}
                <div class="card h-100">
                    @if($obat->gambar)
                        <img src="{{ asset('storage/' . $obat->gambar) }}" class="card-img-top" alt="{{ $obat->nama_obat }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/placeholder.png') }}" class="card-img-top" alt="Tidak ada gambar" style="height: 200px; object-fit: cover;"> {{-- Gambar placeholder jika tidak ada gambar --}}
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $obat->nama_obat }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($obat->deskripsi, 50) }}</p>
                        <div class="mt-auto">
                            <p class="fw-bold text-success">Rp {{ number_format($obat->harga, 0, ',', '.') }}</p>
                            {{-- Tombol Aksi (misalnya, lihat detail atau tambah ke keranjang) --}}
                            <a href="{{ route('produk.show', $obat->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            {{-- Form untuk Add to Cart bisa ditambahkan di sini jika perlu --}}
                            <form action="{{ route('produk.addToCart', $obat->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-cart-plus"></i> Beli
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Tidak ada produk yang cocok dengan pencarian Anda.</p>
@endif