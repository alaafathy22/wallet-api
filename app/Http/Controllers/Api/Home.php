<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Home extends Controller
{
    public function con_show(Request $request)
    {
        $auth_login_id = Auth::guard('api')->user()->id;
        $sel_data_wallet = Wallet::where('user_id', $auth_login_id)->with('Details_wallets')->get();
        if (count($sel_data_wallet) == 0) {
            return response()->json([
                'status' => true,
                'UserData_Wallet' => 'لا يوجد محفظة منشأه يجب انشاء محفظة',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'UserData_Wallet' => $sel_data_wallet,
            ]);
        }
    }
}
