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
        $email = $request->userLogin_email;
        $password = $request->userLogin_password;
        $idwallet = $request->id_wallet;

        $token = Auth::guard('api')->attempt(['email' => $email, 'password' => $password]);
        $user_data = Auth::guard('api')->user();
        $user_data->token = $token;
        $sel_data_wallet = DB::table('wallets')->where('user_id', '=', $user_data->id)->get(['id as id_wallet', 'price as price_wallet']);
        $sel_wallet_min_id = DB::table('wallets')->where('user_id', '=', $user_data->id)->min('id');
        $sel_sum_first_wallet = 0;
        $baqyfirstwallet = 0;

        for ($i = 0; $i < $sel_data_wallet->count(); $i++) {
            $sel = DB::table('details')
                ->where('user_id', '=', $user_data->id)
                ->where('user_id_wallet', '=', $sel_data_wallet[$i]->id_wallet)
                ->select('id as id_details', 'details as details_details', 'price as price_details')
                ->get();
            $sel_data_wallet[$i]->select_details = $sel;

            if (empty($sel)) {
                $sel_sum_first_wallet = 0;
                $baqyfirstwallet = 0;
                $sel_data_wallet[$i]->select_sum = $sel_sum_first_wallet;
                $sel_data_wallet[$i]->baqyfirstwallet = $baqyfirstwallet;
            } elseif (isset($idwallet) and  $idwallet == $sel_data_wallet[$i]->id_wallet) {
                $sel_sum_wallet = DB::table('details')->where('user_id', '=', $user_data->id)
                    ->where('user_id_Wallet', '=', $idwallet)->sum('price');
                $sel_data_baqywallet = DB::table('wallets')->where('id', '=', $idwallet)->get('price');
                $baqyyourWAllet = $sel_data_baqywallet[0]->price - $sel_sum_wallet;
                $sel_data_wallet[$i]->select_sum = $sel_sum_wallet;
                $sel_data_wallet[$i]->baqyyourWAllet = $baqyyourWAllet;
            } elseif (isset($idwallet) and  $idwallet !== $sel_data_wallet[$i]->id_wallet) {
                $sel_data_wallet[$i] = "NOT FOUND ANY THING FOR THIS ID ";
            } else {
                $sel_sum_first_wallet = DB::table('details')
                    ->where('user_id', '=', $user_data->id)
                    ->where('user_id_Wallet', '=', $sel_wallet_min_id)->sum('price');
                $sel_wallet_minID_price = DB::select('select price from wallets where id=' . $sel_wallet_min_id);

                $baqyfirstwallet =  $sel_wallet_minID_price[0]->price - $sel_sum_first_wallet;
                $sel_data_wallet[0]->select_sum = $sel_sum_first_wallet;
                $sel_data_wallet[0]->baqyfirstwallet = $baqyfirstwallet;
            }
        }

        if (!$token) {
            return response()->json([
                'status' => false,
                'token' => 'Something error in your data',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'User_token' => $user_data->token,
                'UserData_Wallet' => $sel_data_wallet,
            ]);
        }
    }
}
