<?php

namespace App\Http\Livewire\Admin\Saveaccount;

use App\Models\Saveaccount;
use Livewire\Component;

class Single extends Component
{

    public $saveaccount;

    public function mount(Saveaccount $saveaccount){
        $this->saveaccount = $saveaccount;
    }

    public function delete()
    {
        $this->saveaccount->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Saveaccount') ]) ]);
        $this->emit('saveaccountDeleted');
    }

    public function render()
    {
        return view('livewire.admin.saveaccount.single')
            ->layout('admin::layouts.app');
    }
}
