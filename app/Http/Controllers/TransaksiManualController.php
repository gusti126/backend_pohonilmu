<?php

namespace App\Http\Controllers;

use App\Kememberan;
use App\TransaksiManual;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiManualController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'kememberan_id' => 'required|integer',
            'referal' => 'string'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $userId = Auth::user()->id;
        $user = User::with('profile')->find($userId);

        $kememberanId = $request->input('kememberan_id');
        $kememberan = Kememberan::find($kememberanId);
        if(!$kememberan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data kememberan tidak ada'
            ], 404);
        }
        if($request->file('bukti_pembayaran'))
        {
            $image = $request->file('bukti_pembayaran')->store(
                'assets/bukti_transaksi', 'public');
            $data['bukti_pembayaran'] = url('storage/'.$image);
        }
        if($request->input('referal'))
        {
            $data['referal'] = $request->input('referal');
            if($data['referal'] === $user->profile->refeal)
            {
                $data['referal'] = null;
            }
        }
        $data['user_id'] = $userId;
        // dd($data);

        $bukti_transaksi = TransaksiManual::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'data transaksi manual berhasil admin akan memprosesnya',
            'data' => $bukti_transaksi
        ], 200);


    }
}
