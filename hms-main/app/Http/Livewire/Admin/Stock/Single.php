<?php

namespace App\Http\Livewire\Admin\Stock;

use App\Models\Stock;
use Livewire\Component;

class Single extends Component
{

    public $stock;

    public function mount(Stock $stock){
        $this->stock = $stock;
    }

    public function delete()
    {
        $this->stock->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Stock') ]) ]);
        $this->emit('stockDeleted');
    }

    public function render()
    {
        return view('livewire.admin.stock.single')
            ->layout('admin::layouts.app');
    }
}
