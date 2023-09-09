<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\enterValueWallet;
use App\Models\Detail;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class enterValueForWallets
{
    public function enterValueForWallets_fun(Request $request)
    {
        $message = $request->input_message;
        $value = $request->input_value;
        $wallet_id = $request->id_wallet;
        $user_login_id = Auth::guard('api')->user()->id;
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'input_message' => 'required|max:100',
                'input_value' => 'required|max:10',
            ],
            $messages = [
                'input_message.required' => 'ألزام وجود تفاصيل صرف',
                'input_message.max' => 'الرقم اكبر من اللازم',
                'input_value.required' => 'الزام وجود ال القيمة',
                'input_value.max' => 'القيمة اكبر من اللازم',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        } else {
            if (Wallet::find($wallet_id)) {
                Detail::create([
                    'details' => $message,
                    'price' => $value,
                    'user_id' => $user_login_id,
                    'user_id_wallet' => $wallet_id
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'تم الانشاء'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'خطاً برجاء مراجعه البيانات',
                ]);
            }
        }
    }
}
