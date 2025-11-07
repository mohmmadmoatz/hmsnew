<?php

namespace App\Http\Livewire\Admin\Warehouseexport;

use App\Models\WarehouseExport;
use Livewire\Component;

class Single extends Component
{

    public $warehouseexport;

    public function mount(WarehouseExport $warehouseexport){
        $this->warehouseexport = $warehouseexport;
    }

    public function delete()
    {
        $this->warehouseexport->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('WarehouseExport') ]) ]);
        $this->emit('warehouseexportDeleted');
    }

    public function render()
    {
        return view('livewire.admin.warehouseexport.single')
            ->layout('admin::layouts.app');
    }
}
