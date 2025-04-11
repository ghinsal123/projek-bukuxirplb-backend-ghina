<?php

namespace App\Http\Middleware; //Menandakan bahwa file ini berada dalam folder app/Http/Middleware.

use Closure; //Menggunakan Closure untuk parameter fungsi middleware (fungsi lanjutan setelah middleware dijalankan).
use Illuminate\Http\Request; //Menggunakan class Request untuk menangani data permintaan HTTP.
use Symfony\Component\HttpFoundation\Response; //Menggunakan class Response dari Symfony, dasar dari response HTTP di Laravel.
use Tymon\JWTAuth\Exceptions\JWTException; //Import exception khusus untuk menangani error saat validasi JWT.
use Tymon\JWTAuth\Facades\JWTAuth; //Import JWTAuth facade untuk menangani proses otentikasi berdasarkan token JWT.

//Mendeklarasikan class JwtMiddleware.
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     * Komentar PHPDoc untuk memberi tahu bahwa method handle akan menerima request dan mengembalikan response setelah lanjut ke proses berikutnya ($next).
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response //Method utama yang dijalankan saat route menggunakan middleware ini. Menerima Request dan fungsi next.
    {
        try{
            $user = JWTAuth::parseToken()->authenticate(); //Mencoba untuk membaca token dari request, dan mengautentikasi user. Jika gagal, maka masuk ke blok catch.
        }catch(JWTException $e){ //Menangkap error jika token tidak valid, tidak ada, atau kadaluarsa.
            //Jika terjadi error pada token, kirim response JSON status false dan pesan "Token tidak valid", dengan kode status 401 Unauthorized.
            return response()->json(
                [
                    'status'    => false,
                    'message'   => "Token tidak valid"
                ],401);
        }
        
        // Jika token valid dan user berhasil diautentikasi, maka lanjutkan request ke controller berikutnya.
        return $next($request);
    } //Menutup fungsi handle.
} //Menutup class JwtMiddleware.
