<?php

namespace App\Http\Livewire\Admin\Unit;

use App\Models\Unit;
use Livewire\Component;

class Single extends Component
{

    public $unit;

    public function mount(Unit $unit){
        $this->unit = $unit;
    }

    public function delete()
    {
        $this->unit->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Unit') ]) ]);
        $this->emit('unitDeleted');
    }

    public function render()
    {
        return view('livewire.admin.unit.single')
            ->layout('admin::layouts.app');
    }
}
