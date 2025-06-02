<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotik Gampil - Layanan Kesehatan Terpercaya</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .footer {
            background-color: #212529;
        }
        .product-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .service-card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }
        .nav-link:hover {
            border-bottom: 2px solid #28a745;
            
        }
            .slider {
            width: 100%;
            max-width: 1200px; 
            margin: 0 auto;
            overflow: hidden;
            position: relative;
            border-radius: 10px; 
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            flex: 0 0 100%;
        }

        .slide img {
            width: 100%;
            height: auto;
            display: block;
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


    
    <section class="slider">
        <div class="slides" id="slideContainer">
           <div class="slide"><img src="img/promo.png" alt="1"></div>
           <div class="slide"><img src="img/promo2.png" alt="2"></div>
        </div>
    </section>

    
    <section class="py-5 bg-light produk-section"> 
        <div class="container py-4">
            <h2 class="text-center fw-bold mb-5">Produk Populer</h2>
            
            <div class="row g-4">
               
                <div class="col-sm-6 col-lg-3">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <img src="img/paracetamol.png" class="card-img-top" alt="Obat">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Paracetamol 500mg</h5>
                            <p class="card-text text-muted small">Obat penurun panas dan pereda nyeri</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rp 15.000</span>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus me-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-3">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <img src="img/vitaminc500mg.png" class="card-img-top" alt="Obat">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Vitamin C 500mg</h5>
                            <p class="card-text text-muted small">Suplemen daya tahan tubuh</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rp 25.000</span>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus me-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-sm-6 col-lg-3">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <img src="img/antasida.png" class="card-img-top" alt="Obat">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Antasida</h5>
                            <p class="card-text text-muted small">Obat maag dan gangguan lambung</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rp 12.000</span>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus me-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
              
                <div class="col-sm-6 col-lg-3">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <img src="img/maskermedis.png" class="card-img-top" alt="Obat">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Masker Medis</h5>
                            <p class="card-text text-muted small">Masker 3 ply dengan proteksi tinggi</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rp 30.000/pak</span>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus me-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <button class="btn btn-outline-success border-2 px-4 py-2 fw-bold">Lihat Semua Produk</button>
            </div>
        </div>
    </section>

   


   
    <section class="py-5 bg-success text-white">
        <div class="container py-4 text-center">
            <h2 class="fw-bold mb-4">Butuh Bantuan?</h2>
            <p class="lead mb-5 mx-auto" style="max-width: 600px;">Tim customer service kami siap membantu Anda  melalui layanan chat online atau telepon.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <button class="btn btn-light text-success fw-bold px-4 py-3">
                    <i class="fas fa-phone-alt me-2"></i> Hubungi Kami
                </button>
                <button class="btn btn-outline-light border-2 fw-bold px-4 py-3">
                    <i class="fas fa-comment-alt me-2"></i> Chat Sekarang
                </button>
            </div>
        </div>
    </section>

    
    <footer class="footer text-white pt-5 pb-3">
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
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Senin - Jumat</span>
                            <span>08:00 - 21:00</span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Sabtu</span>
                            <span>09:00 - 17:00</span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Minggu</span>
                            <span>10:00 - 15:00</span>
                        </li>
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

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let index = 0;
        const slides = document.getElementById('slideContainer');
        const totalSlides = slides.children.length;
    
        setInterval(() => {
            index = (index + 1) % totalSlides;
            slides.style.transform = `translateX(-${index * 100}%)`;
        }, 3000); // Ganti slide setiap 3 detik

       document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('dashboardSearchForm');
    const searchInput = document.getElementById('dashboardSearchInput');
    const searchResultsContainer = document.getElementById('dashboardSearchResults');

    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form tradisional
            const query = searchInput.value;

            // Tampilkan loading atau status pencarian jika perlu
            searchResultsContainer.innerHTML = '<p>Mencari produk...</p>';

            fetch(`{{ route('dashboard.searchProduk') }}?search=${encodeURIComponent(query)}`, { // Gunakan route yang akan kita buat
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Penting untuk deteksi AJAX di controller
                    // 'Content-Type': 'application/json', // Tidak perlu untuk GET
                    // 'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tidak perlu untuk GET
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.text(); // Kita harapkan HTML partial
            })
            .then(html => {
                searchResultsContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Error during fetch:', error);
                searchResultsContainer.innerHTML = '<p>Terjadi kesalahan saat mencari produk. Silakan coba lagi.</p>';
            });
        });
    }
});
    </script>
</body>
</html>