<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class creat_wallet
{

    public function creat_wallet(Request $request)
    {
        $name_wallet = $request->name_wallet;
        $input_number_wallet = $request->Value_wallet;
        $user_data = Auth::user();
        $sel_wallet_min_count = Wallet::where('user_id', '=', $user_data->id)->count();
        if ($sel_wallet_min_count < 5) {
            DB::insert("INSERT INTO `wallets`(`name_wallet`,`price`,`user_id`)
                VALUES ('$name_wallet','$input_number_wallet','$user_data->id')");
            $sel_wallet_min_count = Wallet::where('user_id', '=', $user_data->id)->count();
            return response()->json([
                'status' => true,
                'message' => 'Done Added',
                'now count' => $sel_wallet_min_count
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Sorry You must have just five wallets'
            ]);
        }
    }
}
