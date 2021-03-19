<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function mentorEmail(Request $request)
    {
        $emailUser = $request->input('email');
        $mentor = Mentor::where('email', $emailUser)->first();
        if(!$mentor)
        {
            return response()->json([
                'status' => 'error',
                'data' => 'email mentor tidak ada'
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data mentor sesuia email user',
            'data' => $mentor
        ], 200);
    }
}
