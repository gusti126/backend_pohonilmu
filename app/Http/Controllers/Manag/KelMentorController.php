<?php

namespace App\Http\Controllers\Manag;

use App\Http\Controllers\Controller;
use App\Mentor;
use App\User;
use Illuminate\Http\Request;

class KelMentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mentor::with('course.myCourse')->paginate(20);
        // $data = Mentor::with('course')->sum('id');
        // dd($data);
        $jMentor = Mentor::count();


        return view('manag.mentor.index', [
            'items' => $data,
            'jumlah_mentor' => $jMentor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        // dd($user);
        $pengembang = User::where('role', 'pengembang')->get();
        // dd($pengembang);

        return view('manag.mentor.create', [
            'users' => $user,
            'pengembang' => $pengembang
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
            // 'nama', 'email', 'profesi', 'image', 'no_rekening', 'user_id'
            'nama' => 'required|string',
            'email' => 'required|email|unique:mentors',
            'profesi' => 'required|string',
            'image' => 'required',
            'no_rekening' => 'required',
            'user_id' => 'required|integer'
        ]);

        $data = $request->all();
        $image = $request->file('image')->store(
            'assets/mentor', 'public');
            // dd($data);
        $data['image'] = url('storage/'.$image);

        Mentor::create($data);

        return redirect()->route('kel-mentor.index')->with('success', 'Data mentor berhasil di tambahkan');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Mentor::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data Mentor Berhasil di Hapus');
    }
}
