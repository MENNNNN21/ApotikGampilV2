<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi; // Pastikan path model benar

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index(Request $request)
    {
        // Ambil semua transaksi dengan relasi user, urutkan terbaru, dan paginasi
        $query = Transaksi::with('user')->latest();

        // Fitur Pencarian Sederhana (Opsional)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%') // Cari berdasarkan ID
                  ->orWhere('status_pembayaran', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%'); // Cari berdasarkan nama user
                  });
            });
        }

        $transaksis = $query->paginate(15); // Tampilkan 15 data per halaman

        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail transaksi (Opsional).
     */
    public function show(Transaksi $transaksi)
    {
        // Anda bisa memuat relasi lain jika perlu, misal item transaksi
        // $transaksi->load('items.obat');
        return view('admin.transaksi.show', compact('transaksi'));
    }

    // Anda bisa menambahkan metode lain seperti update status jika diperlukan
}