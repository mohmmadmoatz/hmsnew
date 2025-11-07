<?php

namespace App\Http\Livewire\Admin\Stockcat;

use App\Models\Stockcat;
use Livewire\Component;

class Single extends Component
{

    public $stockcat;

    public function mount(Stockcat $stockcat){
        $this->stockcat = $stockcat;
    }

    public function delete()
    {
        $this->stockcat->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Stockcat') ]) ]);
        $this->emit('stockcatDeleted');
    }

    public function render()
    {
        return view('livewire.admin.stockcat.single')
            ->layout('admin::layouts.app');
    }
}
