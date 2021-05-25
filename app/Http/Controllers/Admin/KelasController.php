<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Kategori;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentor = Mentor::where('user_id', Auth::user()->id)->with('course')->paginate(10);
        // $mentor = Mentor::where('user_id', Auth::user()->id)->with('course')->get()->pluck('nama', 'id');
        // $tes =[];
        // foreach($mentor as $m)
        // {
        //     dd($m->course);
        // }
        // dd($mentor);
        $allkelas = Course::with('kategori')->paginate(10);

        return view('pages.kelas.index', [
            'items' => $mentor,
            'all_kelas' => $allkelas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Mentor::where('user_id', Auth::user()->id)->get();
        $mentorAll = Mentor::get();
        $kategori = Kategori::get();

        return view('pages.kelas.create', [
            'items' => $data,
            'kategori' => $kategori,
            'mentor_all' => $mentorAll
        ]);
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
            // 'mentor_id', 'kategori_id', 'nama', 'image', 'sertifikat', 'harga',
        // 'level', 'deskripsi', 'sub_kategori
            'mentor_id' => 'required|integer',
            'nama' => 'string|required',
            'image' => 'image|required',
            'harga' => 'integer|required',
            'level' => 'string',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|integer',
            'sub_kategori' => 'required|string'

        ]);
        $data = $request->all();
        $image = $request->file('image')->store('assets/kelas', 'public');
        $data['image'] = url('storage/'.$image);
        $data['sertifikat'] = 1;
        // dd($data);
        $course = Course::create($data);

        return redirect()->route('kelas.index')->with('toast_success', 'kelas berhasil di tambah');
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
        $data = Course::findOrFail($id);
        // dd($data);
        $mentor = Mentor::where('user_id', Auth::user()->id)->get();
        $mentorAll = Mentor::get();
        $kategori = Kategori::get();

        return view('pages.kelas.edit', [
            'kelas' => $data,
            'mentor' => $mentor,
            'kategori' => $kategori,
            'mentor_all' => $mentorAll
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
        $data = $request->all();
        $course = Course::findOrFail($id);
        // dd($data);
        if($request->file('image'))
        {
            $image = $request->file('image')->store('assets/kelas', 'public');
            $data['image'] = url('storage/'.$image);
        }

        // dd($data);

        $course->update($data);
        return Redirect::route('kelas.index')->with('success', 'Kelas Berhasil di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Course::findOrFail($id);

        if(!$data)
        {
            return Redirect::back()->with('error', 'Gagal Hapus Kelas.');
        }

        $data->delete();
        return Redirect::back()->with('toast_success', 'Kelas Berhasil di Hapus.');
    }
}
