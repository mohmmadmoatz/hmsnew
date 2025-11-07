<?php

namespace App\Http\Livewire\Admin\Fdebittransaction;

use App\Models\FdebitTransaction;
use Livewire\Component;

class Single extends Component
{

    public $fdebittransaction;

    public function mount(FdebitTransaction $fdebittransaction){
        $this->fdebittransaction = $fdebittransaction;
    }

    public function delete()
    {
        $this->fdebittransaction->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('FdebitTransaction') ]) ]);
        $this->emit('fdebittransactionDeleted');
    }

    public function render()
    {
        return view('livewire.admin.fdebittransaction.single')
            ->layout('admin::layouts.app');
    }
}
