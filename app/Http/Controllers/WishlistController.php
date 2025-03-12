<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
{
    $productId = $request->input('product_id');
    $userId = Auth::id();

    // Validasi jika data tidak valid
    if (!$productId || !$userId) {
        session()->flash('error', 'Invalid data!');
        return redirect()->back();
    }

    // Cek apakah produk sudah ada di wishlist
    $exists = Wishlist::where('user_id', $userId)
        ->where('product_id', $productId)
        ->exists();

    if ($exists) {
        session()->flash('message', 'Product already in wishlist!');
        return redirect()->back();
    }

    // Tambahkan produk ke wishlist
    Wishlist::create([
        'user_id' => $userId,
        'product_id' => $productId,
    ]);

    session()->flash('message', 'Product added to wishlist!');
    return redirect()->back();
}


    public function viewWishlist()
    {
        // Ambil wishlist milik user yang sedang login
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('users.wishlist', compact('wishlists'));
    }

    public function removeFromWishlist($id)
    {
        $userId = Auth::id();
        Wishlist::where('user_id', $userId)->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist');
    }
}