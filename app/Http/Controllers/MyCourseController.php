<?php

namespace App\Http\Controllers;

use App\Course;
use App\MyCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
{
    public function index(Request $request)
    {
        $myCourses = MyCourse::query()->with('course');

        $userId = $request->query('user_id');
        $myCourses->when($userId, function($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $myCourses->get()
        ]);
    }
    public function create(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
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

        // cek user id berlangganan atau tidak
        $userId = $request->input('user_id');
        $getUser = getUser($userId);
        // dd($getUser['data']['member_page']['updated_at']);
        // dd($getUser['data']['id']);
        if($getUser['status'] === 'error')
        {
            return response()->json([
                'status' => $getUser['status'],
                'message' => $getUser['message']
            ], 404);
        }

        $p = Carbon::create(date($getUser['data']['member_page']['updated_at']));
        $date = $p->addMonth();
        $waktuHabis = date($date);
        // dd(date($date));
        if (Carbon::now() > $waktuHabis )
        {
            $deleteBerlangganan = deletBerlangganan($getUser['data']['id']);
            if($deleteBerlangganan['status'] === 'error')
            {
                return response()->json([
                    $deleteBerlangganan
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'masa berlangganan anda habis lakukan order kembali'
            ], 400);


        }

        $TotalMyCourse = MyCourse::where('user_id', $userId)->count();
        $maxGabung = $getUser['data']['member_page']['akses_kelas'];
        // dd($TotalMyCourse >= $maxGabung);
        if($TotalMyCourse >= $maxGabung)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'limit akses kelas anda habis silahkan upgrade ke berlangganan yang lebih tinggi',
                $getUser
            ], 400);
        }

        // cek duplikasi data
        $isExistMyCourse =  MyCourse::where('course_id', '=', $courseId)
        ->where('user_id', '=', $userId)->exists();
        if($isExistMyCourse){
            return response()->json([
                'status' => 'error',
                'message' => 'User sudah mengambil course ini'
            ], 409);
        }

        $myCourse = MyCourse::create($data);
        $TotalMyCourse = MyCourse::where('user_id', $userId)->count();
        return response()->json([
            'status' => 'success',
            'message' => 'berhasil create my course',
            'total_course' => $TotalMyCourse,
            'maxGabung' => $maxGabung,
            'data' => $myCourse
        ], 200);

    }
}
