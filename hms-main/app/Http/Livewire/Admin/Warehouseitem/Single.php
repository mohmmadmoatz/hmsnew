<?php

namespace App\Http\Livewire\Admin\Warehouseitem;

use App\Models\Warehouseproduct;
use Livewire\Component;

class Single extends Component
{

    public $warehouseitem;

    public function mount(Warehouseproduct $warehouseitem){
        $this->warehouseitem = $warehouseitem;
    }

    public function delete()
    {
        $this->warehouseitem->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('WarehouseItem') ]) ]);
        $this->emit('warehouseitemDeleted');
    }

    public function render()
    {
        return view('livewire.admin.warehouseitem.single')
            ->layout('admin::layouts.app');
    }
}
