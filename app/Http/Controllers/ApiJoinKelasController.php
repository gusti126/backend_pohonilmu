<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Course;
use App\joinKelas;
use App\JoinLesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiJoinKelasController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $berlangganan = Berlangganan::where('user_id', $userId)->with('kememberan')->orderByDesc('id')->first();
        if(!$berlangganan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user belum menjadi member silahkan lakukan berlangganan'
            ], 400);

        }

        $p = Carbon::create(date($berlangganan->updated_at));
        $date = $p->addMonth();
        $waktu_habis = date($date);

        if(Carbon::now() > $waktu_habis)
        {
            $this->deleteJoinKelas();
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis'
            ], 400);
        }
        $myJoinKelas = joinKelas::where('user_id', $userId)->with('course.mentor')->get();
        $myJoinKelasC = joinKelas::where('user_id', $userId)->count();


        return response()->json([
            'status' => 'success',
            'message' => 'list data join my course',
            'count_data' => $myJoinKelasC,
            'data' => $myJoinKelas
        ], 200);

    }

    public function create(Request $request)
    {
        $rules = [
            'course_id' => 'required|integer'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $userId = Auth::user()->id;
        $user = User::find($userId);

        $course_id = $request->input('course_id');
        $course = Course::find($course_id);
        if(!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'course id tidak di temukan'
            ], 404);
        }

        $berlangganan = Berlangganan::where('user_id', $userId)->with('kememberan')->orderByDesc('id')->first();
        if(!$berlangganan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user belum menjadi member silahkan lakukan berlangganan'
            ], 400);

        }

        $p = Carbon::create(date($berlangganan->updated_at));
        $date = $p->addMonth();
        $waktu_habis = date($date);

        if(Carbon::now() > $waktu_habis)
        {
            $this->deleteJoinKelas();
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis'
            ], 400);
        }

        $totalMyLesson = JoinLesson::where('user_id', $userId)->count();
        $totalMaxGabung = $berlangganan->kememberan->akses_kelas;

        if($totalMyLesson >= $totalMaxGabung)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'limit akses kelas anda habis silahkan upgrade ke berlangganan yang lebih tinggi'
            ], 400);
        }

        // duplikat join kelas
        $isExistsJoinKelas = joinKelas::where('user_id', $userId)->where('course_id', $course_id)->exists();

        if($isExistsJoinKelas)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user sudah mengambil kelas ini'
            ], 400);
        }

        $myJoinKelas = joinKelas::create([
            'user_id' => $userId,
            'course_id' => $course_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'berhasil join kelas',
            'data' => $myJoinKelas
        ], 200);

    }

    // untuk mendelete semua kelas yang pernah di join
    public function deleteJoinKelas()
    {
        $userId = Auth::user()->id;
        $joinMateri = joinKelas::where('user_id', $userId)->get();
        // dd($joinMateri);

        foreach($joinMateri as $j)
        {
            $j->delete();
        }



        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di delete'
        ], 200);
    }

    public function destroyMyCourse($id)
    {
        $data = joinKelas::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id my course not found'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data my course berhasil di hapus'
        ], 200);
    }
}
