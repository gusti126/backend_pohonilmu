<?php

namespace App\Http\Controllers\Manag;

use App\Berlangganan;
use App\Http\Controllers\Controller;
use App\Profile;
use App\TransaksiManual;
use Illuminate\Http\Request;

class ManagTransaksiManualController extends Controller
{
    public function setSuksess($id)
    {
        $transaksi_manual = TransaksiManual::with('kememberan')->find($id);
        $transaksi_manual->update([
            'status' => 'sukses'
        ]);
        Berlangganan::create([
            'user_id' => $transaksi_manual->user_id,
            'kememberan_id' => $transaksi_manual->kememberan_id
        ]);

        if($transaksi_manual->referal != null)
        {
            $referal = $transaksi_manual->referal;
            $profile = Profile::where('referal', $referal)->first();
            if(!$profile)
            {
                return redirect()->route('kel-berlangganan.index')->with('success', 'data transaksi berhasil di ubah referal tidak falid');
            }
            $point = $profile->point + $transaksi_manual->kememberan->get_point;
            $profile->update([
                'point' => $point
            ]);

            return redirect()->route('kel-berlangganan.index')->with('success', 'data transaksi berhasil di ubah referal falid');
        }


        return redirect()->route('kel-berlangganan.index')->with('success', 'data transaksi berhasil di ubah');
    }

    public function setFailed($id)
    {
        $transaksi_manual = TransaksiManual::find($id);
        $transaksi_manual->update([
            'status' => 'gagal'
        ]);

        return redirect()->route('kel-berlangganan.index')->with('success', 'data transaki berhasil di ubah menjadi gagal/failed');
    }
}
