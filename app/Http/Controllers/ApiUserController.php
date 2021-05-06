<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Course;
use App\Mentor;
use App\OrderTripay;
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
        // $riwayat_transaksi = null;
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

        $transaksi = TransaksiManual::where('user_id', Auth::user()->id)->with('kememberan')->get();
        if(!$transaksi)
        {
            $transaksi = null;
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
            'riwayat_transaksi' => $transaksi
        ], 200);



    }

    public function updateProfile(Request $request)
    {
        $rules = [
            // user : 'name', 'email', 'password', 'role', 'rekening_gm', 'phone'
            'name' => 'string|required',
            'email' => 'string|required',
            'phone' => 'string|required',
            // profile table : 'image', 'referal', 'user_id', 'no_tlp', 'alamat', 'tanggal_lahir', 'point', 'jenis_kelamin'
            'alamat' => 'string|required',
            'tanggal_lahir' => 'required',
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
        $profile = Profile::where('user_id', $userId)->first();

        $user->update([
            'name' => $request->input('name'),
        ]);

        $profile->update([
            'alamat' => $request->input('alamat'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
        ]);

        // validasi email
        $email_input = $request->input('email');
        // dd(User::where('email', $email_input)->count() <= 0); hasilnya false
        // cek ini itu milik user yang sedang login ?
        if($email_input === $user->email)
        {
            // cek apakah email ini sudah pernah daftar
            if(User::where('email', $email_input)->count() <= 1)
            {
                $user->update([
                    'email' => $email_input
                ]);
            }
        }else{
            if(User::where('email', $email_input)->exists())
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'gagal update email user telah di gunakan masukan email yang lain',
                    'data' => $user
                ], 400);
            }
            $user->update([
                    'email' => $email_input
            ]);
        }

        // validasi phone
        $phone_input = $request->input('phone');
        if($phone_input === $user->phone)
        {
            if(User::where('phone', $phone_input)->count() <= 1)
            {
                $user->update([
                    'phone' => $phone_input
                ]);
            }
        }else{
            if(User::where('phone', $phone_input)->exists())
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'gagal update nomor telepon telah di gunakan masukan nomor yang lain',
                    'data' => $user
                ], 400);
            }

            $user->update([
                    'phone' => $phone_input
                ]);
        }

        if($request->file('image'))
        {
            $image = $request->file('image')->store(
                'assets/profile', 'public');
            $data['image'] = url('storage/'.$image);

            $profile->update([
                'image' => $data['image'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data user berhasil di update',
            'data' => $user,
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
        // cek apakaah by referal ada
        if($profile)
        {
            $user = User::where('id', $profile->user_id)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'pencarian user berdasarkan referal',
                'data' => $user
            ], 200);
        }

        $userByPhone = User::where('phone', $referal)->first();
        if($userByPhone)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'pencarian user berdasarkan phone',
                'data' => $userByPhone
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'data referal tidak di temukan'
        ], 404);

    }

    // public function cariReferalByPhone(Request $request)
    // {

    // }

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

    public function riwayatReferal()
    {
        $userId = Auth::user()->id;
        $user = User::with('profile')->find($userId);
        $referalUser = $user->profile->referal;
        $riwayat_referal = null;

        $from_transaksi_manual = TransaksiManual::where('referal', $referalUser)->with('user', 'kememberan')->get();
        // dd($from_transaksi_manual);
        if($from_transaksi_manual)
        {
            $riwayat_referal['referal_transaksi_manul'] = $from_transaksi_manual;
        }
        $from_tripay = OrderTripay::where('referal', $referalUser)->get();
        if($from_tripay)
        {
            $riwayat_referal['referal_paytri'] = $from_tripay;
        }
        // dd($riwayat_referal);

        return response()->json([
            'status' => 'success',
            'message' => 'data riwayat refrensi referal',
            'data' => $riwayat_referal
        ], 200);

    }


}
