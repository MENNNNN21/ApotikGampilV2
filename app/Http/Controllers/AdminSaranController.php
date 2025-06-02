<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontakModel; 

class AdminSaranController extends Controller
{
    public function index(Request $request)
    {
        $kontaks = KontakModel::all();
        return view('admin.saran.index', compact('kontaks'));
    }
    public function show($nama)
    {
        // Validasi apakah nama yang diberikan ada dalam database
        if (!KontakModel::where('nama', $nama)->exists()) {
            return redirect()->route('admin.saran.index')->with('error', 'Saran tidak ditemukan.');
        }

        // Temukan saran berdasarkan nama
        $kontaks = KontakModel::where('nama', $nama)->firstOrFail();
        return view('admin.saran.show', compact('kontaks'));
    }
    public function destroy($nama)
    {
        // Validasi apakah nama yang diberikan ada dalam database
        if (!KontakModel::where('nama', $nama)->exists()) {
            return redirect()->route('admin.saran.index' )->with('error', 'Saran tidak ditemukan.');
        }

        // Temukan dan hapus saran berdasarkan nama
        $saran = KontakModel::findOrFail($nama);
        $saran->delete();
        return redirect()->route('admin.saran.index')->with('success', 'Saran berhasil dihapus.');
    }
}
