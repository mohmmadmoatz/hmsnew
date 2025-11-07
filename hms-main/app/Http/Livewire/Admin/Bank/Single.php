<?php

namespace App\Http\Livewire\Admin\Bank;

use App\Models\Bank;
use Livewire\Component;

class Single extends Component
{

    public $bank;

    public function mount(Bank $bank){
        $this->bank = $bank;
    }

    public function delete()
    {
        $this->bank->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Bank') ]) ]);
        $this->emit('bankDeleted');
    }

    public function render()
    {
        return view('livewire.admin.bank.single')
            ->layout('admin::layouts.app');
    }
}
