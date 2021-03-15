<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lesson::get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data lesson',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'chapter_id' => 'integer|required',
            'video' => 'required|string'
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $chapterId = $request->input('chapter_id');
        $chapter = Chapter::find($chapterId);
        if(!$chapter)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Chapter id tidak di temukan'
            ], 404);
        }

        $video_url = $request->input('video');
        // mengambil link id youtube
        parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
        $data['video'] = $my_array_of_vars['v'];

        $lesson = Lesson::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $lesson
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
        $data = Lesson::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data id lesson tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail lesson',
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
            'nama' => 'string|',
            'chapter_id' => 'integer|',
            'video' => '|string'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $chapterId = $request->input('chapter_id');
        if($chapterId)
        {
            $chapter = Chapter::find($chapterId);
            if(!$chapter)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chapter id tidak di temukan'
                ], 404);
            }
        }

        $lesson = Lesson::find($id);
        if(!$lesson){
            return  response()->json([
                'status' => 'error',
                'message' => 'lesson Tidak di Temukan'
            ], 404);
        }

        $videoId = $request->input('video');
        if($videoId){
            // mengambil link id youtube
            parse_str( parse_url( $videoId, PHP_URL_QUERY ), $my_array_of_vars );
            $data['video'] = $my_array_of_vars['v'];
        }
        // update lesson
        $lesson->fill($data);
        $lesson->save();

        return response()->json([
            'status' => 'success',
            'message' => 'data lesson berhasil di update',
            'data' => $lesson
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
        $data = Lesson::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id lesson tidak ada'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }
}
