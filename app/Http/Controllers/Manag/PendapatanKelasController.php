<?php

namespace App\Http\Controllers\Manag;

use App\Chapter;
use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Mentor;
use App\User;
use Illuminate\Http\Request;

class PendapatanKelasController extends Controller
{
    public function index()
    {
        $kelas = Course::withCount('myCourse')->with('kategori', 'mentor')->paginate(6);
        // dd($kelas);
        $counK = Course::count();
        $counM = Mentor::count();
        $counC = Chapter::count();
        $countL = Lesson::count();
        $counP = User::where('role', 'pengembang')->count();
        $BayaraMentor = 0;
        $pendapatan = 0;

        foreach($kelas as $k)
        {
            $t = $k->my_course_count;
            $BayaraMentor += $t;
            $pendapatan += $t;
        }

        $BayaraMentor *= 100;
        // $pendapatan *= 1000;
        $pendapatan = TransaksiSukses();
        $sisaUang = $pendapatan - $BayaraMentor;
        // dd('pendapatan = '.$pendapatan, 'bayaran semua mentor = '. $BayaraMentor, 'Total Pendapatan = '.$sisaUang);
        return view('manag.kelas.pendapata', [
            'kelas' => $kelas,
            'bayar_mentor' => $BayaraMentor,
            'pendapatan' => $pendapatan,
            'sisa_uang' => $sisaUang,
            'count_kelas' => $counK,
            'count_pengembang' => $counP,
            'count_mentor' => $counM,
            'count_chapter' => $counC,
            'count_lesson' => $countL
        ]);
    }
}
