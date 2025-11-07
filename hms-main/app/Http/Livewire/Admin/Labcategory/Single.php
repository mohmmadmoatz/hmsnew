<?php

namespace App\Http\Livewire\Admin\Labcategory;

use App\Models\LabCategory;
use Livewire\Component;

class Single extends Component
{

    public $labcategory;

    public function mount(LabCategory $labcategory){
        $this->labcategory = $labcategory;
    }

    public function delete()
    {
        $this->labcategory->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('LabCategory') ]) ]);
        $this->emit('labcategoryDeleted');
    }

    public function render()
    {
        return view('livewire.admin.labcategory.single')
            ->layout('admin::layouts.app');
    }
}
