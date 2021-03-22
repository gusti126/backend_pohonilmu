<?php

namespace App\Http\Controllers;

use App\Kememberan;
use Illuminate\Http\Request;

class ApiKememberanController extends Controller
{
    public function index()
    {
        $data = Kememberan::get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data kememberan',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $data = Kememberan::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id kememberan tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail kememberan',
            'data' => $data
        ], 200);
    }
}
