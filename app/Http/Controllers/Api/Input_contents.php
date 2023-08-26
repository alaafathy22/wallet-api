<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Input_contents
{
    public function Input_contents_for_user(Request $request)
    {

        $message = $request->input_message;
        $value = $request->input_value;
        $wallet = $request->id_wallet;
        $user_data = Auth::user();
        $sel_wallet_min_id = Wallet::where('user_id', '=', $user_data->id)->min('id');
        $sel_data_wallet = DB::table('user_wallet')->where('id', '=', $wallet)->where('user_id', '=', $user_data->id)->get();

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'input_message' => 'required|max:100',
                'input_value' => 'required|max:10',
            ],
            $messages = [
                'input_message.required' => 'ألزام وجود تفاصيل صرف',
                'input_message.max' => 'الرقم اكبر من اللازم',
                'input_value.required' => 'الزام وجود ال الرقم',
                'input_value.max' => 'الرقم اكبر من اللازم',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        if ($wallet and $sel_data_wallet->count() >= 1) {
            DB::insert("INSERT INTO `details`(`details`,`price`,`user_id`,`user_id_wallet`)
            VALUES ('$message','$value','$user_data->id','$wallet')");
            return response()->json([
                'status' => true,
                'message' => 'Done Added'
            ]);
        } elseif (!$wallet and $sel_wallet_min_id != NULL) {
            $wallet = $sel_wallet_min_id;
            DB::insert("INSERT INTO `details`(`details`,`price`,`user_id`,`user_id_wallet`)
            VALUES ('$message','$value','$user_data->id','$wallet')");
            return response()->json([
                'status' => true,
                'message' => 'Done Added'
            ]);
        } elseif ($sel_wallet_min_id == NULL) {
            return response()->json([
                'status' => false,
                'message' => 'You have to create your first wallet'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You have to create your first wallet'
            ]);
        }
    }
}
