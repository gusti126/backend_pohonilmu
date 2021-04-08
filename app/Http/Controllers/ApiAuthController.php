<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            // 'email' => 'required',
            'password' => 'required|string',
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $phone = User::where('phone', $data['email'])->first();
        if($phone)
        {
            if (Hash::check($data['password'], $phone->password)) {
                $token = $phone->createToken('myToken')->accessToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'login berhasil dengan nomor telepon',
                    'data' => $phone,
                    'token' => $token
                ], 200);
            }
            // dd($data);
            // dd(Hash::check($data['password'], $user_no_tlp->password));

            return response()->json([
                'status' => 'error',
                'message' => 'password salah'
            ], 401);
        }
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;
            $data['token'] = $token;

            return response()->json([
                'status' => 'success',
                'message' => 'login dengan email berhasil',
                'data' => $user,
                'token' => $data['token']
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'gagal login email atau password salah',

            ], 401);
        }
    }

    public function register(Request $request)
    {
       $rules = [
             'name' => 'required|string',
             'phone' => "required|string|unique:users",
             'jenis_kelamin' => 'string|required|in:Laki - laki,Perempuan',
             'password' => 'required|min:6',
             'alamat' => 'required|string',
        ];
        $messages = [
            'unique' => 'no :attribute sudah terdaftar',
            'required' => ':attribute Harus di isi',
            'min' => ':attribute harus diisi minimal :min karakter ya',
            'max' => ':attribute harus diisi maksimal :max karakter ya' ,
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $name = $request->input('name');
         $email = $request->input('email');
         $phone = $request->input('phone');
         $password = $request->input('password');
         $hasPassword = Hash::make($password);
         $poolEmail = Str::random(22);
         $poolEmailExist = User::where('email', $poolEmail)->first();
        //  dd($poolEmailExist);
        if($poolEmailExist)
        {
            $poolEmail = Str::random(25);
        }
         $user = User::create([
             'name' => $name,
             'email' => $poolEmail,
             'phone' => $phone,
             'password' => $hasPassword

         ]);

         $token = $user->createToken('myToken')->accessToken;
         $pool = '0123456789';
         $referal = substr(str_shuffle(str_repeat($pool, 5)), 0, 12);
         $profile = Profile::create([
             'user_id' => $user->id,
            //  'tanggal_lahir' => $request->input('tanggal_lahir'),
            //  'no_tlp' => $request->input('no_tlp'),
             'jenis_kelamin' => $request->input('jenis_kelamin'),
             'alamat' => $request->input('alamat'),
             'referal' => $referal,
             'point' => 5
         ]);

         return response()->json([
             'status' => 'success',
             'data' => $user,
             'profile' => $profile,
             'token' => $token
         ], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'success',
            'message' => 'logout berhasil'
        ], 200);
    }
}
