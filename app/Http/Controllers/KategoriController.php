<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kategori::with('course')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data kategori',
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
            'nama' => 'string|required'
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $kategori = Kategori::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di tambahkan',
            'data' => $kategori
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
        $data = Kategori::with('course')->find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id kategori tidak ada',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'detail kategori',
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
        $data = $request->all();

        $kategori = Kategori::find($id);
        if(!$kategori)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id kategori tidak ada',
            ], 404);
        }

        $kategori->fill($data);
        $kategori->save();

        return response()->json([
            'status' => 'succes',
            'message' => 'data berhasil di update',
            'data' => $kategori
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
        $data = Kategori::find($id);
        if(!$data)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'id kategori tidak ada',
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil di hapus'
        ], 200);
    }
}
