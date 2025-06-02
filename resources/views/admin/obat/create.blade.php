@extends('admin.layout')

@section('content')
<h4>Tambah Obat Baru</h4>

<form action="{{ route('admin.obat.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Nama Obat</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Kadaluarsa</label>
        <input type="date" name="expired_at" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Gambar (opsional)</label>
        <input type="file" name="gambar" class="form-control">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
