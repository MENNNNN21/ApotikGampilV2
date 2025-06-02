@extends('admin.layout')

@section('content')
<h4>Edit Obat: {{ $obat->nama }}</h4>



<form action="{{ route('admin.obat.update', $obat) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Obat</label>
        <input type="text" name="nama" class="form-control" value="{{ $obat->nama }}" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3">{{ $obat->deskripsi }}</textarea>
    </div>

    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Kadaluarsa</label>
        <input type="date" name="expired_at" class="form-control" value="{{ $obat->expired_at->format('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label>Gambar Saat Ini:</label><br>
        @if($obat->gambar)
            <img src="{{ asset('storage/' . $obat->gambar) }}" alt="Gambar" width="80"><br><br>
        @else
            <span class="text-muted">Belum ada gambar</span><br><br>
        @endif
        <input type="file" name="gambar" class="form-control">
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection