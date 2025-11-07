<?php

namespace App\Http\Livewire\Admin\Stocksup;

use App\Models\Stocksup;
use Livewire\Component;

class Single extends Component
{

    public $stocksup;

    public function mount(Stocksup $stocksup){
        $this->stocksup = $stocksup;
    }

    public function delete()
    {
        $this->stocksup->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Stocksup') ]) ]);
        $this->emit('stocksupDeleted');
    }

    public function render()
    {
        return view('livewire.admin.stocksup.single')
            ->layout('admin::layouts.app');
    }
}
