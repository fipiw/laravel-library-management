<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel master data buku.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 50)->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->integer('tahun');
            $table->integer('stok')->default(0);
            $table->string('cover')->nullable()->comment('Path file cover buku (nilai plus)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
