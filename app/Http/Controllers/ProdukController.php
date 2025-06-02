<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukModel;
use App\Models\ObatModel as Obat;

class ProdukController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('produk.index', compact('obats'));
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('produk.show', compact('obat'));
    }

   public function addToCart($id)
{
    $product = Obat::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

}
