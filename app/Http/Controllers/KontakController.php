<?php

namespace App\Http\Controllers;

use App\Models\KontakModel;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('kontak.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'pesan' => 'required|string|max:1000',
        ]);

        KontakModel::create($request->all());

        return redirect()->route('kontak.index')->with('success', 'Saran berhasil dikirim.');
    }
}
