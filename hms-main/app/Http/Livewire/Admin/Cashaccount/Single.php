<?php

namespace App\Http\Livewire\Admin\Cashaccount;

use App\Models\Cashaccount;
use Livewire\Component;

class Single extends Component
{

    public $cashaccount;

    public function mount(Cashaccount $cashaccount){
        $this->cashaccount = $cashaccount;
    }

    public function delete()
    {
        $this->cashaccount->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Cashaccount') ]) ]);
        $this->emit('cashaccountDeleted');
    }

    public function render()
    {
        return view('livewire.admin.cashaccount.single')
            ->layout('admin::layouts.app');
    }
}
