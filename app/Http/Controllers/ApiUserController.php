<?php

namespace App\Http\Controllers;

use App\Hadiah;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function index()
    {
        $data = User::with('profile')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data user',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $data = User::with('profile')->find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data user tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail user',
            'data' => $data
        ], 200);
    }

    public function profile(Request $request)
    {
        $userId = $request->input('user_id');
        $profile = Profile::query();
        $profile->when($userId, function($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'data profile',
            'data' => $profile->get()
        ], 200);


    }
}
