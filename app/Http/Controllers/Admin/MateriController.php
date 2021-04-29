<?php

namespace App\Http\Controllers\Admin;

use App\Chapter;
use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MateriController extends Controller
{
    public function getMateri($id)
    {
        $materi = Chapter::where('course_id', $id)->with('lesson')->get();
        // dd($materi);

        return view('pages.materi.create', [
            'materi' => $materi,
            'course_id' => $id
        ]);
    }

    public function createLesson(Request $request)
    {
        $data = $request->all();
        $video_url = $request->input('video');
        // mengambil link id youtube
        parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
        if(empty($my_array_of_vars['v']))
        {
            $request->session()->flash('error', 'url video yang anda masukan tidak valid, jika mengalami kebingungan silahkan hubungi admin');
            return Redirect::back();
        }
        $data['video'] = $my_array_of_vars['v'];
        // dd($data);
        $lesson = Lesson::create($data);
        $request->session()->flash('success', 'Materi Berhasil di Tambahkan');
        return Redirect::back();
    }

    public function editLesson($course_id,$id)
    {
        // $data = Course::where('id', $course_id);
        $item = Lesson::findOrFail($id);

        return view('pages.materi.edit', [
            'item' => $item,
            'course_id' => $course_id
        ]);

    }

    public function updateLesson(Request $request, $course_id, $id)
    {
        $data = $request->all();
        $lesson = Lesson::findOrFail($id);
        $video_url = $request->input('video');
        // mengambil link id youtube
        parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
        if(empty($my_array_of_vars['v']))
        {
            $request->session()->flash('error', 'url video yang anda masukan tidak valid, jika mengalami kebingungan silahkan hubungi admin');
            return Redirect::back();
        }
        $data['video'] = $my_array_of_vars['v'];
        $lesson->fill($data);
        $lesson->save();

        return redirect()->route('materi', $course_id)->with('success', 'Materi berhasil di update');

    }

    public function hapusLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->back()->with('success', 'materi berhasil di hapus');
    }

    public function tambahBAB(Request $request)
    {
        $data = $request->all();

        Chapter::create($data);

        $request->session()->flash('success', 'BAB Materi Berhasil di Tambahkan');
        return Redirect::back();

    }

    public function editBAB($id)
    {
        $chapter = Chapter::findOrFail($id);

        return view('pages.BAB.edit', [
            'item' => $chapter
        ]);
    }

    public function updateBAB(Request $request, $id)
    {
        $data = $request->all();
        $chapter = Chapter::findOrFail($id);
        $chapter->fill($data);
        $chapter->save();

        return redirect()->route('materi', $chapter->course_id)->with('success', 'BAB Materi Berhasil di Update');

    }

    public function hapusBAB($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();

        return redirect()->back()->with('success', 'data bab berhasil di hapus');

    }
}
