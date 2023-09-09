<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Delete_Content
{
    public function Delete_Content(Request $request)
    {
        $user_login_id = Auth::guard('api')->user()->id;
        $id_row = $request->Id_For_content;
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'Id_For_content' => 'required',
            ],
            $messages = [
                'Id_For_content.required' => 'ألزام وجود أل رقم السطر المراد حذفه',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $delete_status = Detail::where('id', $id_row)->where('user_id', $user_login_id)->delete();
        if ($delete_status) {
            return response()->json([
                'status' => true,
                'message' => 'تم الحذف'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'برجاء مراجعه البيانات',
            ]);
        }
    }
}
