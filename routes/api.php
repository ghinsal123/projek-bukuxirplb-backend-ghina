<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::prefix('/buku')
    ->middleware([JwtMiddleware::class])
    ->group(function(){
    Route::get('/',[BukuController::class,'index']);
    Route::get('/detil/{id}',[BukuController::class,'show']);
    Route::post('/cari',[BukuController::class,'cari']);
    Route::post('/tambah',[BukuController::class,'store']);
    Route::delete('/hapus/{id}',[BukuController::class,'destroy']);
    Route::patch('/edit/{id}',[BukuController::class,'update']);
});

Route::prefix('/auth')->group(function() {
    //http://localhost:8000/api/auth/login method post
    Route::post('/login',[AuthController::class,'login'])->name('api.auth.login');
    Route::get('/checkstatus',[AuthController::class,'check'])->name('api.auth.check');
    Route::get('/logout',[AuthController::class,'logout'])->name('api.auth.logout');
});