<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ObatModel as Obat;
use App\Models\Transaksi;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function showDashboard()
    {
       
    $totalObat = Obat::count();
    $transaksiHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
    $totalPengguna = User::count();
    $pendapatanHariIni = Transaksi::whereDate('created_at', Carbon::today())->sum('total_harga');
    $stokhampirhabis = Obat::stokHampirHabis()->get();

    return view('admin.dashboard', compact(
        'totalObat',
        'transaksiHariIni',
        'totalPengguna',
        'pendapatanHariIni'
        , 'stokhampirhabis'
    ));
}


        
    
}
