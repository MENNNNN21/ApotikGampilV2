<?php

use App\Http\Controllers\AdminSaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PaymentController;

// Rute Publik Pengguna Biasa
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/search-produk', [DashboardController::class, 'searchProduk'])->name('dashboard.searchProduk');
Route::get('/dashboard/hasil-pencarian', [DashboardController::class, 'showResultsPage'])->name('dashboard.showResultsPage');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::post('/produk/{id}/add-to-cart', [CartController::class, 'store'])->name('produk.addToCart');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/kontak',[KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// Rute Logout User Biasa
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Notifikasi Midtrans (tidak memerlukan auth session)
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

// --- RUTE ADMIN ---
Route::get('/admin/login', [AuthAdminController::class, 'showLoginAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthAdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

// Grup untuk semua rute admin yang memerlukan autentikasi admin
Route::middleware(['auth:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard'])->name('dashboard');
        Route::get('/addproduk', function(){
            return view('admin.AddProduk');
        })->name('addproduk.form');

        // Rute Transaksi Admin
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');

        // Rute Obat Admin
        Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
        Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
        Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
        Route::get('/obat/{obat}', [ObatController::class, 'show'])->name('obat.show');
        Route::get('/obat/{obat}/edit', [ObatController::class, 'edit'])->name('obat.edit');
        Route::put('/obat/{obat}', [ObatController::class, 'update'])->name('obat.update');
        Route::delete('/obat/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');

        // Rute Saran Admin
        Route::get('/saran', [AdminSaranController::class, 'index'])->name('saran.index');
        Route::delete('/saran/{id}', [AdminSaranController::class, 'destroy'])->name('saran.destroy');
        Route::get('/saran/{id}', [AdminSaranController::class, 'show'])->name('saran.show');
    });

// Rute User Biasa yang Terautentikasi
Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Profile Routes
    Route::get('/profil', [UserController::class, 'profile'])->name('profile');
    Route::get('/profil/edit', [UserController::class, 'edit'])->name('user.edit_profile');
    Route::put('/profil/update', [UserController::class, 'update'])->name('user.update');

    // Checkout & Payment Routes
    Route::get('/checkout/validasi', [PaymentController::class, 'validasi'])->name('checkout.validasi');
    Route::post('/checkout/validasi', [PaymentController::class, 'simpanValidasi'])->name('checkout.simpan-validasi');
    Route::match(['GET', 'POST'],'/checkout/pay', [PaymentController::class, 'pay'])->name('checkout.pay');
});