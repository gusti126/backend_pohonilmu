<?php

namespace App\Http\Controllers\Admin;

use App\Chapter;
use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;


class MateriController extends Controller
{
    public function getMateri($id)
    {
        $materi = Chapter::where('course_id', $id)->with('lesson')->get();
        // dd($materi);
        $course = Course::find($id);

        return view('pages.materi.create', [
            'materi' => $materi,
            'course_id' => $id,
            'course' => $course
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
            Alert::error('Error pada url', 'url materi tidak dapat di akses oleh sistem');
            // $request->session()->flash('error', 'url video yang anda masukan tidak valid, jika mengalami kebingungan silahkan hubungi admin');
            return Redirect::back()->with('errors', 'url materi tidak falid');
        }
        $data['video'] = $my_array_of_vars['v'];
        // dd($data);
        $lesson = Lesson::create($data);
        // $request->session()->flash('success', 'Materi Berhasil di Tambahkan');
        return Redirect::back()->with('toast_success', 'Materi Berhasil ditambah');
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

        return redirect()->route('materi', $course_id)->with('toast_success', 'Materi berhasil di update');

    }

    public function hapusLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->back()->with('toast_success', 'materi berhasil di hapus');
    }

    public function tambahBAB(Request $request)
    {
        $data = $request->all();

        Chapter::create($data);

        $request->session()->flash('toast_success', 'BAB Materi Berhasil di Tambahkan');
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

        return redirect()->route('materi', $chapter->course_id)->with('toast_success', 'BAB Materi Berhasil di Update');

    }

    public function hapusBAB($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();

        return redirect()->back()->with('toast_success', 'BAB berhasil di hapus');

    }
}
