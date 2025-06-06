<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotik Gampil - @yield('title', 'Halaman')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        .nav-link:hover {
            border-bottom: 2px solid #28a745;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Header --}}
    <header class="bg-light text-white shadow-sm">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-light py-2">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="../img/apotikgampil.png" alt="Logo" width="100" height="100" class="me-2">
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

    {{-- Konten --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer text-white pt-5 pb-3 bg-dark mt-auto">
        <div class="container pt-4">
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <h4 class="fw-bold mb-3">Apotek Sehat</h4>
                    <p class="text-white-50 mb-3">Menyediakan obat-obatan berkualitas dan layanan kesehatan profesional sejak 2010.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white-50 fs-5"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="fw-bold mb-3">Link Cepat</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Produk</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Promo</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Artikel Kesehatan</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="fw-bold mb-3">Jam Operasional</h4>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2 d-flex justify-content-between"><span>Senin - Jumat</span><span>08:00 - 21:00</span></li>
                        <li class="mb-2 d-flex justify-content-between"><span>Sabtu</span><span>09:00 - 17:00</span></li>
                        <li class="mb-2 d-flex justify-content-between"><span>Minggu</span><span>10:00 - 15:00</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="text-white-50 small mb-2 mb-md-0">© 2025 Apotik Gampil. Semua hak dilindungi.</p>
                <div class="d-flex gap-4">
                    <a href="#" class="text-white-50 small text-decoration-none">Syarat & Ketentuan</a>
                    <a href="#" class="text-white-50 small text-decoration-none">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
