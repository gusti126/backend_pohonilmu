<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Chapter::get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data',
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
            'nama' => 'string|required',
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
                'message' => 'data course id tidak ada'
            ], 404);
        }

        $chapter = Chapter::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'data chapter berhasil di tambahkan',
            'data' => $data
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
        $data = Chapter::with('lesson')->find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id chapter tidak di temukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail chapter',
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
            'nama' => 'string',
            'course_id' => 'integer'
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
        if($courseId)
        {
            $course = Course::find($courseId);
            if(!$course)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'data course id tidak ada'
                ], 404);
            }
        }

        $chapter = Chapter::find($id);
        if(!$chapter)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id chapter tidak di temukan'
            ], 404);
        }

        $chapter->fill($data);
        $chapter->save();

        return response()->json([
            'status' => 'success',
            'message' => 'data chapter berhasil di update',
            'data' => $chapter
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
        $data = Chapter::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data chapter id tidak di temukan'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }
}
