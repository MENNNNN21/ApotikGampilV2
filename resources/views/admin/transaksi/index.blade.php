@extends('admin.layout') {{-- Sesuaikan dengan nama layout admin Anda --}}

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
        {{-- Tombol Tambah (jika perlu input manual) --}}
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Transaksi
        </a> --}}
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
            {{-- Form Pencarian --}}
            <form action="{{ route('admin.transaksi.index') }}" method="GET" class="d-inline-block">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm bg-light border-0" placeholder="Cari ID / User / Status..." value="{{ request('search') }}">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->id }}</td>
                                <td>{{ $transaksi->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td>{{ $transaksi->created_at->format('d M Y, H:i') }}</td>
                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $status = $transaksi->status_pembayaran;
                                        $badgeClass = '';
                                        switch ($status) {
                                            case 'lunas':
                                            case 'settlement':
                                                $badgeClass = 'bg-success';
                                                break;
                                            case 'pending':
                                                $badgeClass = 'bg-warning text-dark';
                                                break;
                                            case 'gagal':
                                            case 'ditolak':
                                            case 'kadaluarsa':
                                            case 'cancel':
                                                $badgeClass = 'bg-danger';
                                                break;
                                            case 'challenge':
                                                $badgeClass = 'bg-info';
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Tambahkan tombol lain jika perlu (misal: Update Status) --}}
                                    {{-- <button class="btn btn-warning btn-sm" title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data transaksi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tampilkan Link Paginasi --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $transaksis->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

{{-- Jika Anda menggunakan DataTables atau CSS/JS khusus, tambahkan di sini --}}
@push('styles')
    {{-- <link href="path/to/your/css.css" rel="stylesheet"> --}}
@endpush

@push('scripts')
    {{-- <script src="path/to/your/js.js"></script> --}}
@endpush