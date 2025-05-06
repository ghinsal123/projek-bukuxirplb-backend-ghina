<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'buku';
    public function up(): void
    {
        //
        Schema::create($this->table,function(Blueprint $kolom){
            $kolom->integer('id_buku',true,true);
            $kolom->string('judul_buku',100)->nullable(false);
            $kolom->string('pengarang',100)->nullable(false);
            $kolom->string('penerbit',100)->nullable(false);
            $kolom->string('cover',200)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists($this->table);
    }
};
