<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image1')->nullable(); // gambar utama besar
            $table->string('image2')->nullable(); // gambar kecil 1
            $table->string('image3')->nullable(); // gambar kecil 2
            $table->string('image4')->nullable(); // gambar kecil 3
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
