<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'nama_produk',
        'foto',
        'deskripsi',
        'harga',
        'id_kategori',
        'foto_lainnya',
        'stok',
    ];

    

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_produk', 'id_produk');
    }
    public function transaksi()
{
    return $this->hasMany(Transaksi::class, 'id_produk', 'id_produk');
}

}
