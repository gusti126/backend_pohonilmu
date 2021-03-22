<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Kememberan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBerlanggananController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        // $profile = Profile::query();
        // $profile->when($userId, function($query) use ($userId) {
        //     return $query->where('user_id', '=', $userId);
        // });
        $berlangganan = Berlangganan::query();
        $berlangganan->when($userId, function($query) use ($userId){
            return $query->where('user_id', '=', $userId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $berlangganan->get()
        ], 200);

    }

    public function create(Request $request)
    {
        $rules = [
            'user_id' => 'integer|required',
            'kememberan_id' => 'integer|required'
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $userId = $request->input('user_id');
        $user = User::find($userId);
        if(!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user id tidak di temukan'
            ], 404);
        }
        $kememberanId = $request->input('kememberan_id');
        $kememberan = Kememberan::find($kememberanId);
        if(!$kememberan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'kememberan id tidak ada'
            ], 404);
        }

        // cek apakah sudah berlangganan
        $isExistBerlangganan =  Berlangganan::where('kememberan_id', '=', $kememberanId)
        ->where('user_id', '=', $userId)->exists();
        if($isExistBerlangganan){
            return response()->json([
                'status' => 'error',
                'message' => 'User sudah berlangganan'
            ], 409);
        }

        $data = $request->all();
        $berlangganan = Berlangganan::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di tambahkan',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = Berlangganan::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id berlangganan tidak ada'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }
}
