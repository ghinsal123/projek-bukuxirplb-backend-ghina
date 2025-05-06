<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Illuminate\Log\log;

class AuthController extends Controller
{
    public function check()
    {
        //Validasi Token
        try {
            if (JWTAuth::parseToken()->check()) {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Token Valid',
                    'user'      => JWTAuth::parseToken()->authenticate()
                ], 200);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Token Invalid'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status'    => false,
                'message'   => 'Token Invalid'
            ], 401);
        }
    }
    //
    public function login(Request $request)
    {
        $userPassword = $request->only('email', 'password');
        
        try {
            if (! $token = JWTAuth::attempt($userPassword)):
                return response()->json(
                    [
                        'status'    => false,
                        'message'   => "Login gagal, user atau password salah!"
                    ],
                    401//unauthorized
                );
            endif;

            $user = auth()->user();

            return response()->json([
                'status'    => true,
                'message'   => 'Login Berhasil',
                'user'      => $user,
                'token'     => $token
            ]);
        } catch (JWTException $e) {
            return $e->getMessage();
        }
    }
    public function logout(){
      $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        auth()->logout();
        if($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ],200);
        }

    }
}
