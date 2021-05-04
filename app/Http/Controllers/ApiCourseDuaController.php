<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class ApiCourseDuaController extends Controller
{
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
