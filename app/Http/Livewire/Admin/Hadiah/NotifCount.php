<?php

namespace App\Http\Livewire\Admin\Hadiah;

use App\Hadiah;
use App\TukarHadiah;
use Livewire\Component;

class NotifCount extends Component
{
    public function render()
    {
        $hadiah_pendingC = TukarHadiah::where('status', 'pending')->count();
        return view('livewire.admin.hadiah.notif-count', [
            'hadiah_pendingC' => $hadiah_pendingC
        ]);
    }
}
