<?php

namespace App\Http\Livewire\Admin\Opostpond;

use App\Models\Opostpond;
use Livewire\Component;

class Single extends Component
{

    public $opostpond;

    public function mount(Opostpond $opostpond){
        $this->opostpond = $opostpond;
    }

    public function delete()
    {
        $this->opostpond->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Opostpond') ]) ]);
        $this->emit('opostpondDeleted');
    }

    public function render()
    {
        return view('livewire.admin.opostpond.single')
            ->layout('admin::layouts.app');
    }
}
