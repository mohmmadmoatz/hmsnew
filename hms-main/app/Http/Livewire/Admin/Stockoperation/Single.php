<?php

namespace App\Http\Livewire\Admin\Stockoperation;

use App\Models\Stockoperation;
use Livewire\Component;

class Single extends Component
{

    public $stockoperation;

    public function mount(Stockoperation $stockoperation){
        $this->stockoperation = $stockoperation;
    }

    public function delete()
    {
        $this->stockoperation->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Stockoperation') ]) ]);
        $this->emit('stockoperationDeleted');
    }

    public function render()
    {
        return view('livewire.admin.stockoperation.single')
            ->layout('admin::layouts.app');
    }
}
