<?php

namespace App\Http\Livewire\Admin\Operation;

use App\Models\Operation;
use Livewire\Component;

class Single extends Component
{

    public $operation;

    public function mount(Operation $operation){
        $this->operation = $operation;
    }

    public function delete()
    {
        $this->operation->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Operation') ]) ]);
        $this->emit('operationDeleted');
    }

    public function render()
    {
        return view('livewire.admin.operation.single')
            ->layout('admin::layouts.app');
    }
}
