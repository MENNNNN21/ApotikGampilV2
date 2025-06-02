<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\ObatModel as Obat;

class CartController extends Controller
{
   public function index()
{
    $cartItems = Cart::with('obat')->where('user_id', Auth::id())->get();
   $total = $cartItems->sum(function ($item) {
    return $item->obat->harga * $item->jumlah;
});


    return view('cart', compact('cartItems', 'total'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|integer|min:1',
    ]);

    $item = Cart::where('id', $id)->where('user_id',  Auth::id())->firstOrFail();
    $produk = Obat::findOrFail($item->produk_id);

    // ✅ Cek stok
    if ($request->jumlah > $produk->stok) {
        return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia.');
    }

    $item->update(['jumlah' => $request->jumlah]);

    return redirect()->back()->with('success', 'Jumlah berhasil diperbarui.');
}


public function destroy($id)
{
    $item = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $item->delete();

    return redirect()->back();
}
 public function store(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:obats,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $produk = Obat::findOrFail($request->produk_id);

    // ✅ Cek stok
    if ($produk->stok < $request->jumlah) {
        return redirect()->back()->with('error', 'Stok tidak mencukupi.');
    }

    // Cek apakah produk sudah ada di keranjang user
    $existingCartItem = Cart::where('user_id', Auth::id())
                            ->where('produk_id', $produk->id)
                            ->first();

    if ($existingCartItem) {
        $totalJumlah = $existingCartItem->jumlah + $request->jumlah;

        // ✅ Cek stok jika ditambahkan
        if ($produk->stok < $totalJumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah total.');
        }

        $existingCartItem->update([
            'jumlah' => $totalJumlah,
        ]);
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}

public function checkout()
{
    $cartItems = Cart::with('obat')->where('user_id', Auth::id())->get();

    foreach ($cartItems as $item) {
        $obat = $item->obat;

        // Cek stok lagi sebelum checkout (untuk berjaga-jaga)
        if ($obat->stok < $item->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk: ' . $obat->nama);
        }

        // Kurangi stok
        $obat->stok -= $item->jumlah;
        $obat->save();
    }

    // Hapus semua item di keranjang setelah checkout
    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('cart.index')->with('success', 'Checkout berhasil! Terima kasih.');
}


}
