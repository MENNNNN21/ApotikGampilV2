<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObatModel; // Pastikan path model ini benar

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function showResultsPage(Request $request)
        {
            $searchQuery = $request->input('search');
            $obats = collect(); // Default ke collection kosong

            if (!empty($searchQuery)) {
                $obats = ObatModel::where('nama', 'like', '%' . $searchQuery . '%')
                                    // ->orWhere('deskripsi', 'like', '%' . $searchQuery . '%') // Opsional
                                    ->paginate(12); // Gunakan paginate jika hasilnya banyak
            }

            // Mengembalikan view HALAMAN PENUH BARU, bukan partial
            return view('hasil_pencarian_page', [
                'obats' => $obats,
                'searchQuery' => $searchQuery
            ]);
        }
    }
