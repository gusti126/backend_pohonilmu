<?php

namespace App\Http\Controllers;

use App\Hadiah;
use App\Profile;
use App\TukarHadiah;
use App\User;
use Carbon\Carbon;
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

    public function tukarHadiah(Request $request)
    {
        $rules = [
            'user_id' => 'integer|required',
            'hadiah_id' => 'integer|required',
            'detail_penerima' => 'required'
        ];
        $data = $request->all();
        $data['detail_penerima'] = $request->input('detail_penerima');

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $userId = $request->input('user_id');
        $user = User::where('id', $userId)->with('profile')->first();
        if(!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id user tidak ada',
            ], 404);
        }
        $hadiah = Hadiah::find($request->input('hadiah_id'));
        if(!$hadiah)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id hadiah tidak ada'
            ], 404);
        }
        $jPointHadiah = $hadiah->jumlah_point;
        $jPointUser = $user->profile->point;
        // dd($jPointHadiah > $jPointUser);
        if($jPointHadiah > $jPointUser)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'point user kurang'
            ], 400);
        }
        $status = 'pending';
        if($jPointHadiah > 400)
        {
            $status = 'pending';
        }
        $point = $jPointUser - $jPointHadiah;
        $profile = Profile::where('user_id', $userId)->first();
        $profile->update([
            'point' => $point
        ]);

        $metadata = $data['detail_penerima'];
        $penukaran_hadiah = TukarHadiah::create([
            'user_id' => $userId,
            'hadiah_id' => $hadiah->id,
            'metadata' => json_encode($metadata),
            'status' => $status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'penukaran point berhasil data akan di proses',
            'data' => $penukaran_hadiah
        ], 200);

        return "ok";



    }
}
