<?php

namespace App\Http\Livewire\Admin\Warehouse;

use App\Models\Warehouse;
use Livewire\Component;

class Single extends Component
{

    public $warehouse;

    public function mount(Warehouse $warehouse){
        $this->warehouse = $warehouse;
    }

    public function delete()
    {
        $this->warehouse->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Warehouse') ]) ]);
        $this->emit('warehouseDeleted');
    }

    public function render()
    {
        return view('livewire.admin.warehouse.single')
            ->layout('admin::layouts.app');
    }
}
