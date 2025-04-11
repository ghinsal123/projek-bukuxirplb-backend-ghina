<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/buku')->group(function(){
    Route::get('/',[BukuController::class,'index'])->name('buku.index');
    Route::post('/tambah',[BukuController::class,'store'])->name('buku.tambah');
    Route::put('/edit/{id}',[BukuController::class,'update'])->name('buku.Rest.update');
});