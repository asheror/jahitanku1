<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogUsersController extends Controller
{
    /**
     * Menampilkan semua blog.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data blog
        $blogs = Blog::all();

        return view('users.blog-list', compact('blogs'));
    }

    /**
     * Menampilkan detail blog berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        // Mengambil data blog berdasarkan ID
        $blog = Blog::findOrFail($id);

        return view('blog.detail', compact('blog'));
    }
}
