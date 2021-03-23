<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Mentor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Mentor::with('course')->get();
        $data = Mentor::where('user_id', Auth::user()->id)->withCount('course')->get();
        // dd($data);
        // $m =    Mentor::collection();
        // $data = Mentor::where('user_id', Auth::user()->id)->withCount('course')->get();
        // $mycourse = Course::all();
        // foreach($data as $c){
        //     $mycourse = $c->course;
        // }
        // foreach($data as $c){
        //     foreach($c->course as $s){
        //         $mycourse = $s->myCourse;
        //     }
        // }
        // dd($data);


        return view('pages.mentor.index', [
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
        //
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
        $data = Mentor::findOrFail($id);
        // dd($data);
        $user = User::where('role', 'pengembang')->get();

        return view('pages.mentor.edit', [
            'item' => $data,
            'users' => $user
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
        $mentor = Mentor::findOrFail($id);
        // dd($data);
        if($request->file('image'))
        {
            $image = $request->file('image')->store('assets/gallery', 'public');
            $data['image'] = url('storage/'.$image);
        }

        // dd($data);
        $mentor->update($data);
        if(Auth::user()->role === 'admin')
        {
            return redirect()->route('kel-mentor.index')->with('success', 'data mentor berhasil di update');
        }
        return redirect()->route('pengajar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
