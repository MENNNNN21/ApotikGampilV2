<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Apotik Gampil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .nav-link:hover {
            border-bottom: 2px solid #28a745;
        }
        .card-img-top {
            /* Optional: Untuk ukuran gambar yang konsisten */
            height: 200px; 
            object-fit: cover; 
        }
    </style>
</head>
<body>

<header class="bg-light text-white shadow-sm">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-light py-2">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="img/apotikgampil.png" alt="Logo" width="100" height="100" class="me-2">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse navbar-nav" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link text-black {{ request()->is('/') ? 'border-bottom border-2 border-success' : '' }}" href="{{ url('/') }}">
                                Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2 text-black {{ request()->is('produk') ? 'border-bottom border-2 border-success' : '' }}" href="{{ url('/produk') }}">
                                Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black {{ request()->is('tentang') ? 'border-bottom border-2 border-success' : '' }}" href="{{ url('/tentang') }}">
                                Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black {{ request()->is('kontak') ? 'border-bottom border-2 border-success' : '' }}" href="{{ url('/kontak') }}">
                                Kontak
                            </a>
                        </li>
                    </ul>

                     <form action="{{ route('dashboard.showResultsPage') }}" method="GET" class="d-flex"> {{-- Ganti route ke yang baru --}}
            <input type="text" name="search" class="form-control me-2" placeholder="Masukkan nama produk...">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>
                       <a class="btn btn-link text-black position-relative me-2" href="{{ url('/cart')}}"> 
                            <i class="fas fa-shopping-cart fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                @auth
                                    {{ Auth::user()->cart->count() }}
                                @else
                                    0
                                @endauth
                            </span>
                        </a>

                        @auth
                            <div class="dropdown">
                                <a class="btn btn-outline-black border-2 text-black fw-bold px-4 py-2 dropdown-toggle" href="#" role="button" id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUserMenu">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cart.index') }}">Keranjang</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="btn btn-outline-black border-2 text-black fw-bold px-4 py-2" href="{{ url('/login') }}">
                                <i class="fas fa-user me-1"></i> Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="container py-5">
    <h1 class="text-center fw-bold mb-4">Semua Produk</h1>
    <div class="row g-4">
        @foreach ($obats as $obat)
        <div class="col-sm-6 col-lg-3 d-flex">
            <div class="card h-100 border-0 shadow-sm w-100 d-flex flex-column">
                <a href="{{ route('produk.show', $obat->id) }}" style="text-decoration: none; color: inherit;" class="d-block">
                    <img src="{{ asset('storage/' . $obat->gambar) }}" class="card-img-top" alt="{{ $obat->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $obat->nama }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($obat->deskripsi, 50) }}</p>
                    </div>
                </a>
                <div class="card-footer bg-transparent border-top-0 pt-0 mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-success">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                        <form action="{{ route('produk.addToCart', ['id' => $obat->id]) }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $obat->id }}">
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-cart-plus"></i> Beli
                            </button>
                        </form>
                    </div>
                </div>
            </div> 
        </div> 
        @endforeach
    </div> 
</div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>