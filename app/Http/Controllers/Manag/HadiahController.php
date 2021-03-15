<?php

namespace App\Http\Controllers\Manag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HadiahController extends Controller
{
    public function index()
    {
        $hadia = getHadiah();
        $data = $hadia['data'];
        $totalHadiah = count($data);
        $getpenukar = getPenukarHadiah();
        $penukar = $getpenukar['data'];
        $collect = collect($penukar)->pluck('metadata');
        $count = count($collect);
        // dd(json_decode($collect[0], true));
        // $collect->transform(json_decode($collect, true));
        $collect->transform(function ($item, $key) {
            return json_decode($item, true);
        });
        ;
        // dd($collect);
        $paginet = $this->paginate($data);
        return view('manag.point.index',[
            'items' => $paginet,
            'total_hadiah' => $totalHadiah,
            'penukar' => $penukar,
            'collect' => $collect
        ]);
    }

        /**
    * Gera a paginação dos itens de um array ou collection.
    *
    * @param array|Collection $items
    * @param int $perPage
    * @param int $page
    * @param array $options
    *
    * @return LengthAwarePaginator
    */
    public function paginate($items, $perPage = 3, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => 'page',
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
        createHadiah($data);

        return redirect()->route('index-hadiah')->with('success', 'data hadiah berhasil di tambahkan');
    }

    public function delete($id)
    {
        $data = deleteHadiah($id);

        return redirect()->route('index-hadiah')->with('success', 'data hadiah berhasil di hapus');
    }
}
