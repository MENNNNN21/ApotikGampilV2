<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan halaman profil user
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Menampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        // Pastikan user yang sedang login adalah user yang ingin diedit
        if (Auth::user()->id !== $user->id) {
            return redirect()->route('profile')->with('error', 'Anda tidak memiliki izin untuk mengedit profil ini.');
        }
        // Tampilkan form edit profil
        



        return view('user.edit_profile', compact('user'));
    }

    // Menyimpan perubahan profil
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
