@extends('admin.layout')

@section('content')
<div class="container">
    <h4>Detail Data</h4> {{-- Judul lebih generik atau sesuaikan --}}

    
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Nama</th>
                    <td>{{ $kontaks->nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $kontaks->email }}</td>
                </tr>
                <tr>
                    <th>Pesan</th>
                    <td>{{ $kontaks->pesan }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('admin.saran.index') }}" class="btn btn-secondary">Kembali</a>
        
</div>
@endsection