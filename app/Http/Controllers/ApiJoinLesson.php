<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\JoinLesson;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ApiJoinLesson extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $joinMateri = JoinLesson::where('user_id', $userId)->with('lesson')->get();
        $joinMateriC = JoinLesson::where('user_id', $userId)->count();

        $berlangganan = Berlangganan::where('user_id', $userId)->with('kememberan')->orderByDesc('id')->first();
        if(!$berlangganan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user belum menjadi member silahkan lakukan berlangganan'
            ], 400);

        }
        // cek data exapired kememberan user
        $p = Carbon::create(date($berlangganan->updated_at));
        $date = $p->addMonth();
        $waktu_habis = date($date);

        if(Carbon::now() > $waktu_habis)
        {
            $this->deleteJoinLesson();
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'list data join materi user',
            'count_data' => $joinMateriC,
            'data' => $joinMateri
        ], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'lesson_id' => 'required|integer'
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

        $lesson_id = $request->input('lesson_id');
        $lesson = Lesson::find($lesson_id);
        if(!$lesson)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'lesson id tidak di temukan'
            ], 404);
        }

        $userId = Auth::user()->id;
        $berlangganan = Berlangganan::where('user_id', $userId)->with('kememberan')->orderByDesc('id')->first();
        if(!$berlangganan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user belum menjadi member silahkan lakukan berlangganan'
            ], 400);

        }
        // cek data exapired kememberan user
        $p = Carbon::create(date($berlangganan->updated_at));
        $date = $p->addMonth();
        $waktu_habis = date($date);

        if(Carbon::now() > $waktu_habis)
        {
            $this->deleteJoinLesson();
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis'
            ], 400);
        }
        // cek batas join materi kememberan user
        $totalMyLesson = JoinLesson::where('user_id', $userId)->count();
        $totalMaxGabung = $berlangganan->kememberan->akses_kelas;

        if($totalMyLesson >= $totalMaxGabung)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'limit akses kelas anda habis silahkan upgrade ke berlangganan yang lebih tinggi'
            ], 400);
        }

        // cek duplikat join materi
        $isExistsJoinMateri = JoinLesson::where('user_id', $userId)->where('lesson_id', $lesson_id)->exists();
        if($isExistsJoinMateri)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user sudah mengambil materi ini'
            ], 400);
        }
        $joinMateri = JoinLesson::create([
            'user_id' => $userId,
            'lesson_id' => $lesson_id
        ], 200);

        return response()->json([
            'status' => 'success',
            'message' => 'berhasil create data join materi',
            'data' => $joinMateri
        ], 200);
    }

    public function deleteJoinLesson()
    {
        $userId = Auth::user()->id;
        $joinMateri = JoinLesson::where('user_id', $userId)->get();
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
}
