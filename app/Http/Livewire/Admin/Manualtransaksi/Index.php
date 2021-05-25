<?php

namespace App\Http\Livewire\Admin\Manualtransaksi;

use App\TransaksiManual;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Index extends Component
{
    public function render()
    {
        // toast('Your Post as been submited!','success');
        $transaksiP = TransaksiManual::where('status', 'pending')->latest()->get();
        return view('livewire.admin.manualtransaksi.index', [
            'pending' => $transaksiP
        ]);
    }

    public function setSuksess($id)
    {
        $data = TransaksiManual::find($id);
        if(!$data)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => ' Approved Berhasil',
                'timer'=>3000,
                'icon'=>'error',
                'toast'=>true,
                'showConfirmButton' => false,
                'position'=>'top-right'
            ]);
        }

        $data->update([
            'status' => 'sukess'
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => ' Approved Berhasil',
            'timer'=>3000,
            'icon'=>'success',
            'toast'=>true,
            'showConfirmButton' => false,
            'position'=>'top-right'
        ]);
    }
}
