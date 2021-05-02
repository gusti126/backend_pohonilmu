<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Course;
use App\Lesson;
use App\MyCourse;
use App\MyEpisode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
{

    public function index()
    {
        $myCourse = MyEpisode::where('user_id', Auth::user()->id)->with('course')->get();
        if(!$myCourse)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user belum bergabung ke kelas'
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data list my course',
            'data' => $myCourse
        ], 200);

    }

    public function create(Request $request)
    {
        $rules = [
            'lesson_id' => 'required|integer',
            'course_id' => 'required|integer'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $courseId = $request->input('course_id');

        $course = Course::find($courseId);
        if(!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'course id tidak di temukan'
            ], 404);
        }



        $lessonId = $request->input('lesson_id');
        $lesson = Lesson::find($lessonId);
        if(!$lesson)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'lesson tidak ada'
            ], 404);
        }


        // cek user id berlangganan atau tidak
        $userId = Auth::user()->id;
        $berlangganan = Berlangganan::where('user_id', $userId)->first();
        if(!$berlangganan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user tidak berlangganan'
            ], 404);
        }
        $getUser = User::with('berlangganan.kememberan')->find($userId);
        // dd($getUser->berlangganan->kememberan->akses_kelas);
        // dd($getUser['data']['member_page']['updated_at']);
        // dd($getUser['data']['id']);


        $p = Carbon::create(date($getUser->berlangganan->updated_at));
        $date = $p->addMonth();
        $waktuHabis = date($date);
        // dd(date($date));
        if (Carbon::now() > $waktuHabis )
        {
            $berlangganan->delete();
            MyEpisode::where('user_id', $userId)->delete();
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis lakukan order kembali'
            ], 400);


        }

        $TotalMyCourse = MyEpisode::where('user_id', $userId)->count();
        $maxGabung = $getUser->berlangganan->kememberan->akses_kelas;
        // dd($TotalMyCourse >= $maxGabung);
        // cek batas limit akses kelas
        if($TotalMyCourse >= $maxGabung)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'limit akses kelas anda habis silahkan upgrade ke berlangganan yang lebih tinggi',
                $getUser
            ], 400);
        }

        // cek duplikasi data
        $isExistMyCourse =  MyEpisode::where('course_id', '=', $courseId)
        ->where('user_id', '=', $userId)->where('lesson_id', '=', $lessonId)->exists();
        if($isExistMyCourse){
            return response()->json([
                'status' => 'error',
                'message' => 'User sudah mengambil video dalam course ini'
            ], 409);
        }

        // cek apakah lesson itu kepunyaan course


        $data['user_id'] = $userId;
        $myCourse = MyEpisode::create($data);
        $TotalMyCourse = MyEpisode::where('user_id', $userId)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'berhasil create my course',
            'total_course' => $TotalMyCourse,
            'maxGabung' => $maxGabung,
            'data' => $myCourse
        ], 200);

    }
}
