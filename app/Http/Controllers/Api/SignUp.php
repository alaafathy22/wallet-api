<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SignUp
{

    public function creatUser(Request $request)
    {
        $user_name = $request->user_name_SignUp;
        $user_email = $request->user_email_SignUp;
        $user_password = bcrypt($request->user_password_SignUp);

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'user_name_SignUp' => 'required',
                'user_email_SignUp' => 'required',
                'user_password_SignUp' => 'required|max:10',
            ],
            $messages = [
                'user_name_SignUp.required' => 'لأ يمكن ترك الاسم فارغ',
                'user_email_SignUp.required' => 'لا يمكن ترك الاميل فارغ',
                'user_password_SignUp.required' => 'الزام وجود ال الرقم',
                'user_password_SignUp.max' => 'الرقم اكبر من اللازم',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        try {
            $create_status = User::create([
                'name' => $user_name,
                'email' => $user_email,
                'password' => $user_password,
            ]);

            if (count([$create_status])) {
                $token = Auth::guard('api')->attempt(['email' => $user_email, 'password' => $request->user_password_SignUp]);
                $user_data = Auth::guard('api')->user();
                $user_data->token = $token;
                return response()->json([
                    'status' => True,
                    'message' => 'تم التسجيل',
                    'user_data' => $user_data
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'msg' => 'تأكد من البيانات',
                ]);
            }
        } catch (PDOException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'هذا الاميل مسجل من قبل ويجب ان يكون الاسم مختلف',
            ]);
        }
    }
}
