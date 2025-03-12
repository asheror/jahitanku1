<?php

// models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id_kategori';

    // Sesuaikan dengan kolom yang ada di tabel
    protected $fillable = [
        'kategori',
        'jenis_kategori',
    ];
}
