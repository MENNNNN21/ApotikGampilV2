@extends('admin.layout')

@section('content')
<h4>Daftar Saran</h4>

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kontaks as $kontak)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kontak->nama }}</td>
            <td width="20px">{{ $kontak->email }}</td>
            <td>{{ $kontak->pesan }}</td>
            <td>
                <a href="{{ route('admin.saran.show', $kontak->nama) }}" class="btn btn-info btn-sm">Detail</a>
                <form action="{{ route('admin.saran.destroy', $kontak->nama) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>

@endsection


