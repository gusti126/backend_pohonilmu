<?php

namespace App\Http\Controllers;

use App\Course;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $data = Review::get();

        return response()->json([
            'status' => 'success',
            'mesage' => 'list data review',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $review = Review::with('course')->find($id);
        if(!$review)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data review tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail data review',
            'data' => $review
        ], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'note' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
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
                'message' => 'data id course tidak di temukan',

            ], 404);
        }

        $userId = $request->input('user_id');
        $user = User::find($userId);
        if(!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id user tidak ada'
            ], 404);
        }

        $isExistReview = Review::where('course_id', '=', $courseId)
                                ->where('user_id', '=', $userId)
                                ->exists();
        if ($isExistReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'review already exist'
            ], 409);
        }

        $review = Review::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'data review berhasil di tambahkan',
            'data' => $review
        ], 200);
    }

    public function destroy($id)
    {
        $data = Review::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'data review tidak di temukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'data review berhasil di delete'
        ], 200);
    }

}
