<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Edit_Content
{
    public function Edit_Content_For_User(Request $request)
    {
        $message = $request->input_New_message;
        $value = $request->input_New_value;
        $id = $request->id_For_content;
        $user_data = Auth::user();
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'input_New_message' => 'required|max:100',
                'input_New_value' => 'required|max:10',
                'id_For_content' => 'required',

            ],
            $messages = [
                'input_New_message.required' => 'ألزام وجود تفاصيل صرف',
                'input_New_message.max' => 'الرقم اكبر من اللازم',
                'input_New_value.required' => 'الزام وجود ال الرقم',
                'input_New_value.max' => 'الرقم اكبر من اللازم',
                'id_For_content.required' => 'الزام وجود ال الرقم',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        if (DB::table('details')->where('user_id', '=', $user_data->id)->find($id)) {
            DB::insert("UPDATE `details` SET `details`='$message',`price`='$value'
            WHERE `id`='$id' and `user_id`='$user_data->id'");
            return response()->json([
                'status' => true,
                'message' => 'Done Updated',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Some error in your data KEY '
            ]);
        }
    }
}
