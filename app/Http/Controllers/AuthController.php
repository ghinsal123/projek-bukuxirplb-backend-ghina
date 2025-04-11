<?php

namespace App\Http\Controllers; //Menentukan namespace (lokasi file ini di folder app/Http/Controllers).

use Illuminate\Http\Request; //Menggunakan class Request untuk mengambil data dari request API (seperti email dan password).
use Tymon\JWTAuth\Exceptions\JWTException; //Menggunakan class JWTException untuk menangani error saat generate token JWT.
use Tymon\JWTAuth\Facades\JWTAuth; //Menggunakan JWTAuth sebagai facade (antarmuka) untuk login, cek token, dll.

//Membuat class AuthController yang mewarisi fungsi dasar dari Controller.
class AuthController extends Controller
{
    //Fungsi login() untuk menangani login API. Request $request digunakan untuk ambil input dari client.
    public function login(Request $request)
    {
        $userPassword = $request->only('email', 'password'); //Mengambil hanya input email dan password dari request dan simpan ke variabel $userPassword.
        try { //Memulai blok try-catch untuk menangani kemungkinan error.
            if (! $token = JWTAuth::attempt($userPassword)): //Mencoba login menggunakan JWTAuth. Jika gagal (!$token), maka login tidak valid.
                // Jika gagal login, kirim response JSON status false dengan pesan error dan HTTP status 401 Unauthorized.
                return response()->json(
                    [
                        'status'    => false,
                        'message'   => "Login gagal, user atau password salah!"
                    ],
                    401
                );
            //Menutup blok if.
            endif;

            //Jika login berhasil, ambil data user yang sedang login dan simpan ke variabel $user.
            $user = auth()->user();

            //Kirim response JSON status true, info user, dan token JWT-nya.
            return response()->json([
                'status'    => true,
                'message'   => 'Login Berhasil',
                'user'      => $user,
                'token'     => $token
            ]);
        } catch (JWTException $e) { //Tangani error kalau gagal generate token JWT. Tapi saat ini masih kosong (sebaiknya tambahkan pesan error).
        }
    }
}
