<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk'); // Primary key with 'id_produk'
            $table->string('nama_produk'); // Product name
            $table->string('foto'); // Main product photo
            $table->json('foto_lainnya')->nullable(); // Additional photos stored as JSON
            $table->text('deskripsi'); // Product description
            $table->decimal('harga', 10, 2); // Product price
            $table->integer('stok')->nullable(); // Product stock, nullable
            $table->foreignId('id_kategori')->constrained('categories', 'id_kategori')->onDelete('cascade'); // Foreign key to 'categories'
            $table->timestamps(); // Timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('products'); // Drops products table
    }
}
