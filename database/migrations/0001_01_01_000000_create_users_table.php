<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Default primary key with 'id'
            $table->string('email')->unique(); // Unique email
            $table->string('password'); // Password
            $table->string('phone_number')->nullable(false); // Phone number (not nullable)
            $table->string('address')->nullable(); // Address (nullable)
            $table->date('registration_date'); // Registration date
            $table->string('role')->default('user'); // Role with default 'user'
            $table->timestamps(); // Timestamps
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft deletes
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('users'); // Drops users table
    }
}
