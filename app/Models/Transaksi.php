<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Specify the table if it differs from the pluralized model name
    protected $primaryKey = 'id_transaksi'; // Specify the primary key if it's not the default 'id'

    // Tambahkan properti fillable
    protected $fillable = [
        'user_id',
        'id_produk',
        'quantity',
        'subtotal',
        'status', // Pastikan untuk menambahkan 'status' ke sini
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}
