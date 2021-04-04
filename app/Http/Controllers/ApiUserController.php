<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Course;
use App\Hadiah;
use App\Mentor;
use App\Profile;
use App\TransaksiManual;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function profile()
    {

        $data = User::where('id', Auth::user()->id)->with('profile')->first();
        $isMentor = false;
        $mycourse = null;
        $pendapatan = null;
        $riwayat_transaksi = null;
        $mentor = Mentor::where('email', Auth::user()->email)->first();
        if($mentor)
        {
            $isMentor = $mentor;
            $course = Course::where('mentor_id', $mentor->id)->withCount('myCourse')->get();
            $mycourse = $course;
            // dd($course);
            foreach($course as $c)
            {
                $p = $c->my_course_count;
                $pendapatan += $p;
            }
        }
        $transaksi = TransaksiManual::where('id', Auth::user()->id)->get();
        if($transaksi)
        {
            $riwayat_transaksi = $transaksi;
        }
        $berlangganan = Berlangganan::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->with('kememberan')->first();
        $pendapatan *= 100;
        // dd($pendapatan);

        return response()->json([
            'status' => 'success',
            'message' => 'my profile user',
            'data' => $data,
            'isMentor' => $isMentor,
            'myCourse' => $mycourse,
            'pendapatan' => $pendapatan,
            'berlangganan' => $berlangganan,
            'riwayat_transaksi' => $riwayat_transaksi
        ], 200);



    }

    public function cariReferal(Request $request)
    {
        $rules = [
            'referal' => 'required',
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $referal = $request->input('referal');
        $profile = Profile::where('referal', $referal)->first();
        if(!$profile)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'referal tidak di temukan'
            ], 404);
        }
        $user = User::where('id', $profile->user_id)->with('profile')->first();

        return response()->json([
            'status' => 'success',
            'message' => 'hasil pencarian referal',
            'data' => $user
        ], 200);

    }

    public function tambahPoint(Request $request)
    {
        $rules = [
            'referal' => 'required|integer',
            'tambah_point' => 'required|integer'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $referal = $request->input('referal');
        $profile = Profile::where('referal', $referal)->first();
        if(!$profile)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'profile id tidak ada'
            ], 404);
        }

        $tambahPoint = $request->input('tambah_point');
        $point = $profile->point + $tambahPoint;
        $profile->update([
            'point' => $point
        ]);

        return response()->json([
            'status' => 'succes',
            'message' => 'point berhasil di tambahkan',
            'data' => $profile
        ], 200);
    }

}
