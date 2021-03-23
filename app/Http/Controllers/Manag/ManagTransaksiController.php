<?php

namespace App\Http\Controllers\Manag;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class ManagTransaksiController extends Controller
{
    public function index()
    {
        $data = Order::with('user', 'kememberan')->get();
        // $data_count_harga = Order::with('kememberan')->where('status', 'success')->get();
        // // dd($data_count_harga);
        // $total = 0;
        // foreach($data_count_harga as $h)
        // {
        //     $t = $h->kememberan->harga;
        //     $total += $t;
        // }
        $total = TransaksiSukses();
        // dd($total);
        // dd($total, $data_count_harga);
        return view('pages.transaksi.index', [
            'items' => $data,
            'total_transaksi_sukses' => $total,
        ]);

    }
}
