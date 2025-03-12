<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id(); // Kolom id (primary key dan auto increment)
            $table->string('judul'); // Kolom judul (string)
            $table->string('gambar')->nullable(); // Kolom gambar (nullable)
            $table->text('isi_blog'); // Kolom isi_blog (text)
            $table->unsignedBigInteger('view')->default(0); // Kolom view (default 0)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
