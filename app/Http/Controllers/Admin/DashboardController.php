<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Mentor;
use App\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // $mentor = Mentor::where('user_id', Auth::user()->id)->withCount('course')->get();
        // $mentorCount = Mentor::where('user_id', Auth::user()->id)->count();
        // // dd($mentorCount);
        // $total = 0;
        // $courseCount = 0;
        // foreach($mentor as $m)
        // {
        //     $myC = Course::where('mentor_id', $m->id)->with('myCourse')->get();
        //     foreach($myC as $k)
        //     {
        //         $t = MyCourse::where('course_id', $k->id)->count();
        //         $total = $t;
        //     }
        //     $courseCount += $m->course_count;
        // }
        // $bayaran = 500*$total;
        // // dd($courseCount);
        // return view('dashboard.pengembang', [
        //     'items' => $mentor,
        //     'bayaran' => $bayaran,
        //     'total_course' => $courseCount,
        //     'total_mentor' => $mentorCount,
        //     'total_join_course' => $total
        // ]);

        return redirect()->route('dashboard');
    }
}
