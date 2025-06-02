{{-- resources/views/dashboard/hasil_pencarian_page.blade.php --}}

@extends('layouts.app') {{-- Ganti dengan nama file layout utama Anda --}}

@section('content')
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
                </ol>
            </nav>
            @if (!empty($searchQuery))
                <h2 class="mb-3">Hasil Pencarian untuk: "{{ $searchQuery }}"</h2>
            @else
                <h2 class="mb-3">Hasil Pencarian</h2>
            @endif
        </div>
    </div>

    {{-- Di sinilah kita menggunakan kembali partial view untuk menampilkan produk --}}
    @if (isset($obats))
        @include('produk_items_dashboard', ['obats' => $obats]) {{-- Mengirim variabel $obats ke partial --}}
    @else
        <p>Tidak ada data produk untuk ditampilkan.</p>
    @endif

    {{-- Tampilkan pagination links jika Anda menggunakan paginate() di controller --}}
    @if (isset($obats) && $obats instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="d-flex justify-content-center mt-4">
        {{ $obats->appends(['search' => $searchQuery])->links() }}
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection