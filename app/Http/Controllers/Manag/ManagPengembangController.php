<?php

namespace App\Http\Controllers\Manag;

use App\Course;
use App\Http\Controllers\Controller;
use App\Mentor;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class ManagPengembangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('role', 'pengembang')->paginate(10);

        return view('manag.pengembang.index', [
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
        $data = User::where('role', 'user')->get();

        return view('manag.pengembang.create', [
            'users' => $data
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
            'rekening_gm' => 'required|string'
        ]);
        $data = $request->all();
        // dd($data);
        $user = User::findOrfail($data['id_user']);
        // dd($user);
        $user->update([
            'role' => 'pengembang',
            'rekening_gm' => $data['rekening_gm']
        ]);

        return redirect()->route('kel-pengembang.index')->with('success', 'pengembang berhasil di daftarkan');
        // $pengembang->update([
        //     ''
        // ])
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengembang = User::where('role', 'pengembang')->with('profile')->findOrFail($id);
        // dd($pengembang);
        $mentor = Mentor::where('user_id', $pengembang->id)->get();
        // total gabung kelas
        $total = 0;
        // total semua kelas
        foreach($mentor as $m)
        {
            $course = Course::where('mentor_id', $m->id)->withCount('myCourse')->get();
            foreach($course as $c)
            {
                $total += $c->my_course_count;
            }
        }
        $total *= 500;
        // dd($total);

        return view('manag.pengembang.detail', [
            'pendapatan' => $total,
            'item' => $pengembang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('role', 'pengembang')->with('profile')->findOrFail($id);

        return view('manag.pengembang.edit', [
            'item' => $user
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
        $user = User::findOrFail($id);
        if($request->file('image'))
        {
            $image = $request->file('image')->store(
            'assets/pengembang', 'public');
                // dd($data);
            $data['image'] = url('storage/'.$image);
            $profile = Profile::where('id', $user->id)->update([
                'image' => $data['image']
            ]);
        }

        return redirect()->route('kel-pengembang.index')->with('success', 'data pengembang berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->update([
            'role' => 'user'
        ]);

        return redirect()->route('kel-pengembang.index')->with('success', 'berhasil mencopot status pengembang');
    }
}
