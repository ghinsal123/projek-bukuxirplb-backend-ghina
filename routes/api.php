<?php

use App\Http\Controllers\AuthController;    // Import controller yang akan digunakan
use App\Http\Controllers\BukuController;    // Import controller yang akan digunakan
use App\Http\Middleware\JwtMiddleware;      // Import middleware untuk JWT (autentikasi token)
use Illuminate\Http\Request;                // Untuk menangani request
use Illuminate\Support\Facades\Route;       // Untuk mendefinisikan rute API

// Contoh rute untuk mendapatkan data user yang sedang login (dengan Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user(); // Mengembalikan data user saat ini
})->middleware('auth:sanctum'); // Hanya bisa diakses jika sudah login lewat sanctum

// Group route dengan prefix "/buku" dan middleware JWT (harus login token dulu)
Route::prefix('/buku')
->middleware([JwtMiddleware::class]) // Middleware untuk cek token JWT
->group(function(){
    Route::get('/',[BukuController::class,'index'])->name('buku.index'); // GET /api/buku → Menampilkan semua buku
    Route::get('/detil/{id}',[BukuController::class,'show']); // GET /api/buku/detil/{id} → Menampilkan data buku berdasarkan ID
    Route::post('/cari',[BukuController::class,'cari']); // POST /api/buku/cari → (rute tambahan, kamu harus punya method 'cari' di BukuController)
    Route::post('/tambah',[BukuController::class,'store'])->name('buku.tambah'); // POST /api/buku/tambah → Menambahkan data buku baru
    Route::delete('/hapus/{id}',[BukuController::class,'destroy']);  // DELETE /api/buku/hapus/{id} → Menghapus buku berdasarkan ID
    Route::put('/edit/{id}',[BukuController::class,'update'])->name('buku.Rest.update'); // PUT /api/buku/edit/{id} → Mengedit/update buku berdasarkan ID
});

// Group route untuk autentikasi user, prefix "/auth"
Route::prefix('/auth')->group(function(){
    //http://localhost:8000/api/login method post
    Route::post('/login',[AuthController::class,'login'])->name('api.auth.login'); // POST /api/auth/login → Login user dan mendapatkan token
    Route::get('/checkstatus',[AuthController::class,'check'])->name('api.auth.login'); // GET /api/auth/checkstatus → Mengecek apakah token valid (harus ada method check di AuthController)
});