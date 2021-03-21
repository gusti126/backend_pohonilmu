<?php

namespace App\Http\Controllers;

use App\Hadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiHadiahController extends Controller
{
    public function index()
    {
        $data = Hadiah::get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data hadiah',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $data = Hadiah::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id hadiah not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail hadiah',
            'data' => $data
        ], 200);
    }


    public function create(Request $request)
    {
        $rules = [
            'note' => 'string|required',
            'image' => 'required'
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
    }
}
