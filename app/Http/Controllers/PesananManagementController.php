<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class PesananManagementController extends Controller
{
    // Tampilkan semua pesanan
    public function index(Request $request)
{
    $query = Transaksi::with('product');

    // Terapkan filter jika ada
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }
    if ($request->filled('id_transaksi')) {
        $query->where('id_transaksi', $request->id_transaksi);
    }
    if ($request->filled('nama_produk')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('nama_produk', 'like', '%' . $request->nama_produk . '%');
        });
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $transaksis = $query->get();

    return view('admin.PesananManagement', compact('transaksis'));
}


    // Simpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'id_produk' => 'required',
            'quantity' => 'required|integer',
            'subtotal' => 'required|numeric',
            'status' => 'required',
        ]);

        Transaksi::create($request->all());

        return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
    }

    // Edit pesanan yang ada (hanya status)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $transaksi = Transaksi::find($id);
        $transaksi->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    // Hapus pesanan
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }

    // Ambil data transaksi berdasarkan ID
    public function show($id)
    {
        $transaksi = Transaksi::with('product')->findOrFail($id);
        return response()->json($transaksi);
    }
}


