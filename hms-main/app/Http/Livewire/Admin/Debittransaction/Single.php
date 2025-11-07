<?php

namespace App\Http\Livewire\Admin\Debittransaction;

use App\Models\DebitTransaction;
use Livewire\Component;

class Single extends Component
{

    public $debittransaction;

    public function mount(DebitTransaction $debittransaction){
        $this->debittransaction = $debittransaction;
    }

    public function delete()
    {
        $this->debittransaction->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('DebitTransaction') ]) ]);
        $this->emit('debittransactionDeleted');
    }

    public function render()
    {
        return view('livewire.admin.debittransaction.single')
            ->layout('admin::layouts.app');
    }
}
