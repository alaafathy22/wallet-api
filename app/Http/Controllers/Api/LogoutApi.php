<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutApi
{
    public function LogOut(Request $request)
    {
        $token = $request->auth_token;
        try {
            if ($token) {
                try {
                    JWTAuth::setToken($token)->invalidate();
                    return response()->json([
                        'message' => 'تم تسجيل الخروج',
                    ]);
                } catch (TokenInvalidException $ex) {
                    return response()->json([
                        'status' => false,
                        'message' => 'يوجد مشكله برجاء المراجعه',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'برجاء مراجعه البيانات',
                ]);
            }
        } catch (TokenExpiredException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'you have expired',
            ]);
        }
    }
}
