<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('admin.BlogManagement', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_blog' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('gambar')->store('blog_images', 'public');

        Blog::create([
            'judul' => $request->judul,
            'isi_blog' => $request->isi_blog,
            'gambar' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Blog berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_blog' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi_blog' => $request->isi_blog,
        ];

        if ($request->hasFile('gambar')) {
            if ($blog->gambar && Storage::exists('public/' . $blog->gambar)) {
                Storage::delete('public/' . $blog->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('blog_images', 'public');
        }

        $blog->update($data);

        return redirect()->back()->with('success', 'Blog berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->gambar && Storage::exists('public/' . $blog->gambar)) {
            Storage::delete('public/' . $blog->gambar);
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Blog berhasil dihapus!');
    }
}
