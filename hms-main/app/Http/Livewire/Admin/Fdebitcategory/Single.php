<?php

namespace App\Http\Livewire\Admin\Fdebitcategory;

use App\Models\FdebitCategory;
use Livewire\Component;

class Single extends Component
{

    public $fdebitcategory;

    public function mount(FdebitCategory $fdebitcategory){
        $this->fdebitcategory = $fdebitcategory;
    }

    public function delete()
    {
        $this->fdebitcategory->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('FdebitCategory') ]) ]);
        $this->emit('fdebitcategoryDeleted');
    }

    public function render()
    {
        return view('livewire.admin.fdebitcategory.single')
            ->layout('admin::layouts.app');
    }
}
