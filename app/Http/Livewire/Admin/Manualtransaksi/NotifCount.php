<?php

namespace App\Http\Livewire\Admin\Manualtransaksi;

use App\TransaksiManual;
use Livewire\Component;

class NotifCount extends Component
{
    public function render()
    {
        $pending = TransaksiManual::where('status', 'pending')->count();
        return view('livewire.admin.manualtransaksi.notif-count', [
            'pending_count' => $pending
        ]);
    }
}
