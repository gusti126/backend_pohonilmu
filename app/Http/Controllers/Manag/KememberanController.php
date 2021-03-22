<?php

namespace App\Http\Controllers\Manag;

use App\Http\Controllers\Controller;
use App\Kememberan;
use Illuminate\Http\Request;

class KememberanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kememberan::paginate(10);

        return view('manag.kemember.index', [
            'items' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manag.kemember.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'akses_kelas' => 'required',
            'get_point' => 'required',
            'harga' => 'required'

        ]);
        $data = $request->all();
        // dd($data);

        $kememberan = Kememberan::create($data);

        return redirect()->route('kel-kememberan.index')->with('success', 'Data Kememberan Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Kememberan::findOrFail($id);

        return view('manag.kemember.edit', [
            'item' => $data
        ]);
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
        $request->validate([
            'nama' => 'required',
            'akses_kelas' => 'required',
            'get_point' => 'required',
            'harga' => 'required'

        ]);
        $data = $request->all();

        $kememberan = Kememberan::findOrFail($id);

        $kememberan->fill($data);
        $kememberan->save();

        return redirect()->route('kel-kememberan.index')->with('success', 'data kememberan berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kememberan::findOrFail($id);
        $data->delete();

        return redirect()->route('kel-kememberan.index')->with('success', 'data kememberan berhasil di delete');
    }
}
