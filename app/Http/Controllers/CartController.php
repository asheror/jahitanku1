<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add a product to the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah']++;
            $cart[$id]['subtotal'] = $cart[$id]['jumlah'] * $cart[$id]['harga'];
        } else {
            $cart[$id] = [
                'id_produk' => $product->id_produk,
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'jumlah' => 1,
                'subtotal' => $product->harga,
                'foto' => $product->foto,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('shop.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Show the cart page.
     *
     * @return \Illuminate\View\View
     */
    public function showCart()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        // Menghitung subtotal dari semua barang di keranjang
        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }

        // Mengambil pengguna yang sedang login
        $user = Auth::user();

        // Awalan alamat untuk menentukan ongkir
        $ongkir = 0;
        if ($user && $user->address) {
            $awalAlamat = strtolower($user->address[0]); // Mengambil huruf pertama alamat
            
            // Menentukan ongkir berdasarkan awalan alamat
            switch ($awalAlamat) {
                case 't':
                    $ongkir = 5000;
                    break;
                case 'p':
                    $ongkir = 2000;
                    break;
                case 'b':
                    $ongkir = 10000;
                    break;
                case 'j':
                    $ongkir = 15000;
                    break;
                case 's':
                    $ongkir = 20000;
                    break;
                default:
                    $ongkir = 0; // Ongkir gratis jika tidak memenuhi kondisi
                    break;
            }
        }

        // Menghitung total keseluruhan
        $total = $subtotal + $ongkir;

        return view('users.view-cart', compact('cart', 'subtotal', 'ongkir', 'total'));
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] = $quantity;
            $cart[$id]['subtotal'] = $cart[$id]['harga'] * $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Jumlah produk berhasil diperbarui!');
    }
}
