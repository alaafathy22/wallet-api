<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class SignUp extends Controller
{

    public function creatUser(Request $request)
    {
        $user_name = $request->user_name_SignUp;
        $user_email = $request->user_email_SignUp;
        $user_password = $request->user_password_SignUp;


        $passworAfterCrypt = bcrypt($user_password);
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'user_password_SignUp' => 'required|max:10',
            ],
            $messages = [
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
            DB::insert("INSERT INTO `users`(`name`,`email`,`password`)
            VALUES ('$user_name','$user_email','$passworAfterCrypt')");
            $token = Auth::guard('api')->attempt(['email' => $user_email, 'password' => $user_password]);
            return response()->json([
                'status' => True,
                'message' => 'Done Added',
                'token' => $token
            ]);
        } catch (PDOException $ex) {
            return response()->json([
                'status' => FAlse,
                'message' => 'error this ' . $ex->errorInfo[2] . ' has been added before',
            ]);
        }
    }
}
