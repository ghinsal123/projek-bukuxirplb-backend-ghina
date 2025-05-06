<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //ORM (object relational mapper)
use Laravel\Sanctum\HasApiTokens;

class BukuModel extends Model
{
    //
    use HasApiTokens;
    
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;
    protected $fillable = ['judul_buku','pengarang','penerbit','cover'];
}
