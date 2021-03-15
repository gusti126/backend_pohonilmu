<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mentor::with('course')->get();

        return response()->json([
            'status' => 'succes',
            'message' => 'data list mentor',
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
            'email' => 'string|email|required|unique:mentors',
            'profesi' => 'string|required',
            'image' => 'url|required',
            'no_rekening' => 'required|numeric|min:1'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        // $image = $request->file('image')->store(
        //     'assets/mentor', 'public');
        //     // dd($data);
        // $data['image'] = url('storage/'.$image);
        // dd($data);
        $mentor = Mentor::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'data mentor berhasil di tambahkan',
            'data' => $mentor
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
        $data = Mentor::with('course')->find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data mentor id tidak ada'

            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail mentor',
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
            'email' => 'string|email|unique:mentors',
            'profesi' => 'string',
            'image' => 'url'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        if($request->file('image'))
        {
           $image = $request->file('image')->store(
            'assets/mentor', 'public');
            $data['image'] = url('storage/'.$image);
        }
        $mentor = Mentor::find($id);
        if(!$mentor)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id mentor tidak ada'
            ], 404);
        }

        $mentor->fill($data);
        $mentor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di update',
            'data' => $mentor
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
        $data = Mentor::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'data mentor id tidak ada'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }

    public function getByEmailMentoer(Request $request)
    {
        $rules = [
            'email' => 'string|email|required'
        ];
        $data = $request->all();
        $email = $request->input('email');
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $mentor = Mentor::where('email', $email)->first();
        if(!$mentor)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data mentor tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data mentor sesuai email',
            'data' => $mentor
        ], 200);
    }
}
