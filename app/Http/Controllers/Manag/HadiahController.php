<?php

namespace App\Http\Controllers\Manag;

use App\Hadiah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HadiahController extends Controller
{
    public function index()
    {
        $data = Hadiah::paginate(6);
        $total= Hadiah::count();
        return view('manag.point.index', [
            'items' => $data,
            'total_hadiah' => $total
        ]);

    }



    public function create()
    {
        return view('manag.point.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // note, jumlah_point, 'image;
            'note' => 'required|string',
            'jumlah_point' => 'required|numeric',
            'image' => 'required'
        ]);

        $data = $request->all();
        $image = $request->file('image')->store(
            'assets/hadiah', 'public');
            // dd($data);
        $data['image'] = url('storage/'.$image);
        // dd($data);
        $hadiah = Hadiah::create($data);

        return redirect()->route('index-hadiah')->with('success', 'data hadiah berhasil di tambahkan');
    }

    public function delete($id)
    {
        $data = deleteHadiah($id);

        return redirect()->route('index-hadiah')->with('success', 'data hadiah berhasil di hapus');
    }
}
