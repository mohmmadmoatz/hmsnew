<?php

namespace App\Http\Livewire\Admin\Empcategory;

use App\Models\EmpCategory;
use Livewire\Component;

class Single extends Component
{

    public $empcategory;

    public function mount(EmpCategory $empcategory){
        $this->empcategory = $empcategory;
    }

    public function delete()
    {
        $this->empcategory->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('EmpCategory') ]) ]);
        $this->emit('empcategoryDeleted');
    }

    public function render()
    {
        return view('livewire.admin.empcategory.single')
            ->layout('admin::layouts.app');
    }
}
