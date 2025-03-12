<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.KategoriManagement', compact('categories'));
    }

    
    
    public function store(Request $request)
{
    \Log::info($request->all()); // Log all incoming data

    $request->validate([
        'kategori' => 'required|string|max:255',
        'jenis_kategori' => 'required|string|max:255',
    ]);

    Category::create([
        'kategori' => $request->input('kategori'),
        'jenis_kategori' => $request->input('jenis_kategori'),
    ]);

    return redirect()->back()->with('success', 'Category added successfully!');
}

public function update(Request $request, $id_kategori)
{
    $request->validate([
        'kategori' => 'required|string|max:255',
        'jenis_kategori' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id_kategori);
    $category->update($request->only(['kategori', 'jenis_kategori']));

    return redirect()->back()->with('success', 'Category updated successfully!');
}

    public function destroy($id_kategori)
    {
        $category = Category::findOrFail($id_kategori);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
