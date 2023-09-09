<?php

namespace App\Http\Controllers\Api;

use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Edit_Content
{
    public function Edit_Content_fun(Request $request)
    {
        $message = $request->input_New_message;
        $value = $request->input_New_value;
        $id_row = $request->Id_For_content;
        $user_login_id = Auth::guard('api')->user()->id;

        $update_status = Detail::where('id', $id_row)->where('user_id', $user_login_id)
            ->update([
                'details' => $message,
                'price' => $value,
            ]);
        if ($update_status) {
            return response()->json([
                'status' => true,
                'message' => 'تم التحديث',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'برجاء مراجعه البيانات',
            ]);
        }
    }
}
