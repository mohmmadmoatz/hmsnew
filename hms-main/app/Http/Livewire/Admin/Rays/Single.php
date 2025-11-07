<?php

namespace App\Http\Livewire\Admin\Rays;

use App\Models\Rays;
use Livewire\Component;

class Single extends Component
{

    public $rays;

    public function mount(Rays $rays){
        $this->rays = $rays;
    }

    public function delete()
    {
        $this->rays->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Rays') ]) ]);
        $this->emit('raysDeleted');
    }

    public function render()
    {
        return view('livewire.admin.rays.single')
            ->layout('admin::layouts.app');
    }
}
