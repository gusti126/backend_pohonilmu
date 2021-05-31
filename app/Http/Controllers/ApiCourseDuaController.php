<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class ApiCourseDuaController extends Controller
{
    public function search($keyword)
    {
        $data = Course::where('nama', 'like', '%'.$keyword.'%')->get();
        if(is_null($data))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'filter data kelas berhasil',
            'data' => $data
        ], 200);
    }

    public function kelasTerbaru()
    {

        $data = Course::orderBy('id', 'desc')->limit(8)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'data kelas terbaru',
            'data' => $data
        ], 200);
    }
}
