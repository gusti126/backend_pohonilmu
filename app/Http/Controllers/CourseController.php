<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Course;
use App\Kategori;
use App\Mentor;
use App\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Course::get();

        return response()->json([
            'status' => 'success',
            'message' => 'data list kelas',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            // 'mentor_id', 'kategori_id', 'nama', 'image', 'sertifikat', 'harga',
        // 'level', 'deskripsi'
            'nama' => 'string|required',
            'mentor_id' => 'integer|required',
            'kategori_id' => 'integer|required',
            'sertifikat' => 'boolean|required',
            'harga' => 'integer|required',
            'level' => 'required|in:All-level,Beginer,Intermedaite,Advance',
            'image' => 'image|required',
            'deskripsi' => 'required|string'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $mentorId = $request->input('mentor_id');
        $mentor = Mentor::find($mentorId);
        if(!$mentor)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id mentor tidak di temukan'
            ], 404);
        }

        $kategoriId = $request->input('kategori_id');
        $kategori = Kategori::find($kategoriId);
        if(!$kategori)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id kategori tidak di temukan'
            ], 404);
        }

        $image = $request->file('image')->store(
            'assets/course', 'public');
        $data['image'] = url('storage/'.$image);

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'data course berhasil di tambahkan',
            'data' => $course
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Course::with('kategori', 'mentor', 'chapter.lesson', 'review')->find($id);
        $totalStudent = MyCourse::where('course_id', $id)->count();
        $totalVideos = Chapter::where('course_id', '=', $id)->withCount('lesson')->get()->toArray();
        $finalTotalVideos = array_sum(array_column($totalVideos, 'lesson_count'));
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id course tidak ada'
            ], 404);
        }

        $data['total_student'] = $totalStudent;
        $data['total_videos'] = $finalTotalVideos;

        return response()->json([
            'status' => 'success',
            'message' => 'detail course',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            // 'mentor_id', 'kategori_id', 'nama', 'image', 'sertifikat', 'harga',
        // 'level', 'deskripsi'
            'nama' => 'string|',
            'mentor_id' => 'integer|',
            'kategori_id' => 'integer|',
            'sertifikat' => 'boolean|',
            'harga' => 'integer|',
            'level' => '|in:All-level,Beginer,Intermedaite,Advance',
            'image' => 'image|',
            'deskripsi' => '|string'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $mentorId = $request->input('mentor_id');
        if($mentorId)
        {
            $mentor = Mentor::find($mentorId);
            if(!$mentor)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'id mentor tidak di temukan'
                ], 404);
            }
        }

        $kategoriId = $request->input('kategori_id');
        if($kategoriId)
        {
            $kategori = Kategori::find($kategoriId);
            if(!$kategori)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'id kategori tidak di temukan'
                ], 404);
            }
        }
        $course = Course::find($id);
        if(!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id course tidak ada'
            ], 404);
        }
        if($request->hasFile('image'))
        {
            $image = $request->file('image')->store(
                'assets/course', 'public');
            $data['image'] = url('storage/'.$image);
        }
        $course->fill($data);
        $course->save();

        return response()->json([
            'status' => 'success',
            'message' => 'data course berhasil di update',
            'data' => $course
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Course::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'id course tidak di temukan'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }
}
