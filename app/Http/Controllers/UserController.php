<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        'no_hp' => 'nullable|string|max:255', // Consistent with form
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp
    ];

    // Handle image upload
    if ($request->hasFile('gambar')) {
        // Delete old image if exists
        if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
            Storage::disk('public')->delete($user->gambar);
        }
        
        // Store new image
        $imagePath = $request->file('gambar')->store('profile-images', 'public');
        $updateData['gambar'] = $imagePath;
    }

    $user->update($updateData);

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}