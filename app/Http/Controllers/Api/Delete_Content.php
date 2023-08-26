<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Delete_Content
{
    public function Delete_Content(Request $request)
    {
        $id = $request->Id_For_content;
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'Id_For_content' => 'required',
            ],
            $messages = [
                'Id_For_content.required' => 'ألزام وجود أل الرقم',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        if (DB::table('details')->find($id)) {
            DB::delete("DELETE FROM `details` WHERE `id`=$id ");
            return response()->json([
                'status' => true,
                'message' => 'Deleted'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Some error in your data KEY'
            ]);
        }
    }
}
