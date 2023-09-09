<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class create_wallet
{

    public function create_wallet_fun(Request $request)
    {

        $name_wallet = $request->name_wallet;
        $input_wallet_value = $request->Value_wallet;
        $user_login_id = Auth::guard('api')->user()->id;
        $sel_wallets_count = Wallet::where('user_id', $user_login_id)->count();
        if ($sel_wallets_count <= env('MAXIMUM_WALLETS')) {
            Wallet::create([
                'name_wallet' => $name_wallet,
                'price' => $input_wallet_value,
                'user_id' => $user_login_id
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Done Added',
                'now count' => $sel_wallets_count
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Sorry You must have just ' . env('MAXIMUM_WALLETS') . ' wallets'
            ]);
        }
    }
}
