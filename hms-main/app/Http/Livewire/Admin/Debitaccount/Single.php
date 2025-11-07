<?php

namespace App\Http\Livewire\Admin\Debitaccount;

use App\Models\DebitAccount;
use Livewire\Component;

class Single extends Component
{

    public $debitaccount;

    public function mount(DebitAccount $debitaccount){
        $this->debitaccount = $debitaccount;
    }

    public function delete()
    {
        $this->debitaccount->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('DebitAccount') ]) ]);
        $this->emit('debitaccountDeleted');
    }

    public function render()
    {
        return view('livewire.admin.debitaccount.single')
            ->layout('admin::layouts.app');
    }
}
