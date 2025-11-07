<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use Livewire\Component;

class Single extends Component
{

    public $lab;

    public function mount(Lab $lab){
        $this->lab = $lab;
    }

    public function delete()
    {
        $this->lab->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Lab') ]) ]);
        $this->emit('labDeleted');
    }

    public function render()
    {
        return view('livewire.admin.lab.single')
            ->layout('admin::layouts.app');
    }
}
