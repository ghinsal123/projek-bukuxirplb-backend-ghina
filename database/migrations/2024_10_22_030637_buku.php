<?php

// Import class Migration, Blueprint, dan Schema dari Laravel
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ini membuat migration sebagai class anonymous (tanpa nama)
return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // Menentukan nama tabel sebagai properti di dalam class
    protected $table = 'tabel_buku';

    /**
     * Fungsi ini dijalankan saat migrate.
     * Di sini bikin struktur tabel.
     */
    public function up(): void
    {
        // Buat tabel 'tabel_buku' dengan struktur kolomnya
        Schema::create($this->table, function(Blueprint $struktur){
            $struktur->integer('id_buku',true,true);                 // id_buku: integer, primary key, auto increment
            $struktur->string('judul_buku',255)->nullable(false);   // judul_buku: string maksimal 255 karakter, wajib diisi (not nullable)
            $struktur->string('pengarang',200)->nullable(false);    // pengarang: string maksimal 200 karakter, wajib diisi
            $struktur->year('tahun_terbit')->nullable(false);       // tahun_terbit: tahun, wajib diisi
        });
    }

    /**
     * Fungsi ini dijalankan saat rollback migration.
     * Digunakan untuk menghapus tabel.
     */    
    public function down(): void
    {
        // Menghapus tabel 'tabel_buku' jika ada
        Schema::dropIfExists($this->table);
    }
};
