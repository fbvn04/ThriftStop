<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained('tokos')->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('stok')->default(0);
            $table->string('kategori')->nullable();   // Jacket, Sweater, Kemeja, dll
            $table->string('kondisi')->nullable();    // Seperti Baru, Kondisi Baik, dll
            $table->string('ukuran')->nullable();     // S, M, L, XL — simpan sebagai string/json
            $table->string('foto_utama')->nullable(); // path foto utama (Storage)
            $table->json('foto_lainnya')->nullable(); // array path foto tambahan
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};