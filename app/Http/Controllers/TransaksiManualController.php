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
            if($data['referal'] === $user->profile->referal)
            {
                $data['referal'] = null;
            }

        }
        $data['user_id'] = $userId;
        // dd($data);
        $isExitsTransaksi = TransaksiManual::where('user_id', Auth::user()->id)->where('status', 'pending')->exists();
        if($isExitsTransaksi)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Ada Transaksi Pending di Riwayat Transaksi. Anda Belum Bisa Melakukan Transaksi'
            ], 200);
        }

        $bukti_transaksi = TransaksiManual::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'transaksi berhasil, admin akan memprosesnya',
            'data' => $bukti_transaksi
        ], 200);


    }

    public function destroy($id)
    {
        $data = TransaksiManual::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'data review tidak di temukan'
            ], 404);
        }

        if($data->status === 'sukses')
        {
            return response()->json([
                'status' => 'error',
                'message' =>  'gagal hapus riwayat transaksi karena status transaksi sukses'
            ], 400);
        }

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'data review berhasil di delete'
        ], 200);
    }

    public function isPending($id)
    {
        $transaksi = TransaksiManual::where('user_id', $id)->first();
        if($transaksi)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'ada data transaksi pending'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'tidak ada data transaksi pending'
        ], 200);
    }
}
