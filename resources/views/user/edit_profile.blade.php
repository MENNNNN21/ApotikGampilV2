@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                          <label>Gambar Profil Saat Ini:</label><br>
                            @if($user->gambar)
                                <img src="{{ asset('storage/' . $user->gambar) }}" alt="Gambar Profil" width="80"><br><br>
                            @else
                                <span class="text-muted">Belum ada gambar profil</span><br><br>
                            @endif
                            <input type="file" name="gambar" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
                @endsection
