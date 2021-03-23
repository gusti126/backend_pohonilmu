<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
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

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;
            $data['token'] = $token;

            return response()->json([
                'status' => 'success',
                'message' => 'login berhasil',
                'data' => $user,
                'token' => $data['token']
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'gagal login',

            ], 401);
        }
    }

    public function register(Request $request)
    {
       $rules = [
            'name' => 'required|string',
             'no_tlp' => 'required',
             'jenis_kelamin' => 'string|required',
             'email' => 'required|unique:users|email',
             'password' => 'required|min:6',
             'alamat' => 'required|string',
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
        $name = $request->input('name');
         $email = $request->input('email');
         $password = $request->input('password');
         $hasPassword = Hash::make($password);

         $user = User::create([
             'name' => $name,
             'email' => $email,
             'password' => $hasPassword

         ]);
         $token = $user->createToken('myToken')->accessToken;
         $pool = '0123456789';
         $referal = substr(str_shuffle(str_repeat($pool, 5)), 0, 12);
         $profile = Profile::create([
             'user_id' => $user->id,
             'tanggal_lahir' => $request->input('tanggal_lahir'),
             'no_tlp' => $request->input('no_tlp'),
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
