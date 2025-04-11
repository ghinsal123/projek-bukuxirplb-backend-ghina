<?php

//Ini namespace-nya, artinya file ini termasuk dalam folder App\Models
namespace App\Models;

//Import trait HasFactory dan class Model dari Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Buat class BukuModel yang mewarisi (extends) Model
class BukuModel extends Model
{
    //Pakai trait HasFactory, biasanya dipakai kalau mau buat data dummy (seeder)
    use HasFactory;

    //Menentukan nama tabel yang akan digunakan model ini di database 
    protected $table = 'tabel_buku';
    //Jadi model ini akan mengakses tabel bernama "tabel_buku"

    //Menentukan primary key-nya 'id_buku'
    protected $primaryKey = 'id_buku';

    //Menentukan kolom mana saja yang bisa diisi (mass assigment)
    protected $fillable = [
                            'judul_buku',   //judul buku
                            'pengarang',    //nama pengarang
                            'tahun_terbit'  // tahun terbit buku
                        ];

    // Menonaktifkan timestamps (created_at dan updated_at) karena tidak pakai itu
    public $timestamps = false;
}
