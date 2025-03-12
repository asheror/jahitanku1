<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   

    public function index(Request $request)
{
    // Filter dan urutkan produk
    $query = Product::with('category');
    
    // Filter berdasarkan kategori
    if ($request->filled('category')) {
        $query->where('id_kategori', $request->category);
    }

    // Filter berdasarkan nama produk
    if ($request->filled('name')) {
        $query->where('nama_produk', 'like', '%' . $request->name . '%');
    }

    // Urutkan produk berdasarkan pilihan atau default ke terbaru
    if ($request->filled('sort')) {
        if ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Paginate hasil query menjadi 10 produk per halaman
    $products = $query->paginate(10);
    $categories = Category::all();

    return view('admin.ProductManagement', compact('products', 'categories'));
}



public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        'foto_lainnya.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        'deskripsi' => 'required|string',
        'harga' => 'required|numeric',
        'id_kategori' => 'required|exists:categories,id_kategori',
        'stok' => 'nullable|integer|min:0', // Validasi stok
    ]);

    $filePath = $request->file('foto')->store('product_images', 'public');

    $fotoLainnyaPaths = [];
    if ($request->hasFile('foto_lainnya')) {
        foreach ($request->file('foto_lainnya') as $file) {
            $fotoLainnyaPaths[] = $file->store('product_images', 'public');
        }
    }

    Product::create([
        'nama_produk' => $request->input('nama_produk'),
        'foto' => $filePath,
        'foto_lainnya' => json_encode($fotoLainnyaPaths),
        'deskripsi' => $request->input('deskripsi'),
        'harga' => $request->input('harga'),
        'id_kategori' => $request->input('id_kategori'),
        'stok' => $request->input('stok'), // Menyimpan stok
    ]);

    return redirect()->route('products.index')->with('success', 'Product added successfully.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'foto_lainnya.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        'deskripsi' => 'required|string',
        'harga' => 'required|numeric',
        'id_kategori' => 'required|exists:categories,id_kategori',
        'stok' => 'nullable|integer|min:0', // Validasi stok
    ]);

    $product = Product::findOrFail($id);

    $filePath = $product->foto;
    if ($request->hasFile('foto')) {
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        $filePath = $request->file('foto')->store('product_images', 'public');
    }

    $fotoLainnyaPaths = json_decode($product->foto_lainnya) ?: [];
    if ($request->hasFile('foto_lainnya')) {
        foreach ($request->file('foto_lainnya') as $file) {
            $fotoLainnyaPaths[] = $file->store('product_images', 'public');
        }
    }

    $product->update([
        'nama_produk' => $request->input('nama_produk'),
        'foto' => $filePath,
        'foto_lainnya' => json_encode($fotoLainnyaPaths),
        'deskripsi' => $request->input('deskripsi'),
        'harga' => $request->input('harga'),
        'id_kategori' => $request->input('id_kategori'),
        'stok' => $request->input('stok'), // Menyimpan stok
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}




    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete photo if exists
        if (Storage::exists($product->foto)) {
            Storage::delete($product->foto);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}