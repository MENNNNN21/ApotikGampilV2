<!-- resources/views/admin/layout.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Apotek Gampil')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #198754;
            color: #fff;
            padding-top: 1rem;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #157347;
            border-left: 4px solid #fff;
        }
        .content {
            padding: 2rem;
        }
        .bg-warning {
    background-color: #ffc107 !important;
}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h5 class="text-center">Admin Panel</h5>
            <hr>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.obat.index') }}" class="{{ request()->routeIs('obat.*') ? 'active' : '' }}">Manajemen Obat</a>

            <a href="{{route('admin.transaksi.index')}}" class="{{ request()->is('admin/transaksi*') ? 'active' : '' }}">Transaksi</a>
            <a href="{{ route('admin.saran.index') }}" class="{{ request()->is('admin/kontak*') ? 'active' : '' }}">Saran & Kritik</a>
           <form method="POST" action="{{ route('admin.logout') }}">
    @csrf  {{-- Jangan lupa CSRF token --}}
    <button type="submit" class="btn btn-link nav-link" style="display:inline;cursor:pointer;"> {{-- Anda bisa styling tombol ini agar terlihat seperti link --}}
        Logout Admin
    </button>
</form>
        </div>

        <div class="col-md-10 content">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
