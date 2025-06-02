@extends('admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Obat</h1>

    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('admin.obat.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama obat..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
        <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">+ Tambah Obat</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Expired</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($obats as $i => $obat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $obat->nama }}</td>
                    <td>{{ $obat->kategori }}</td>
                    <td>{{ $obat->stok }}</td>
                    <td>Rp{{ number_format($obat->harga, 0, ',', '.') }}</td>
                    <td>{{ $obat->expired_at }}</td>
                    <td>
                        <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus obat ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
