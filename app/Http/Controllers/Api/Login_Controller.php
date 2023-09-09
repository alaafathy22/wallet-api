<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Login_Controller
{
    public function login_con(Request $request, $email = null, $password = null)
    {
        $email = $request->userLogin_email;
        $password = $request->userLogin_password;

        try {
            $token = Auth::guard('api')->attempt(['email' => $email, 'password' => $password]);
            $user_data = Auth::guard('api')->user();
            $user_data->token = $token;
            return response()->json([
                'status' => true,
                'User_data' => $user_data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'msg' => 'تأكد من البيانات',
            ]);
        }
    }

}
