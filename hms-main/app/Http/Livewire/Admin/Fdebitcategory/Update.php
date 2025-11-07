<?php

namespace App\Http\Livewire\Admin\Fdebitcategory;

use App\Models\FdebitCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $fdebitcategory;

    public $name;
    public $amount;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(FdebitCategory $fdebitcategory){
        $this->fdebitcategory = $fdebitcategory;
        $this->name = $this->fdebitcategory->name;
        $this->amount = $this->fdebitcategory->amount;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('FdebitCategory') ]) ]);
        
        $this->fdebitcategory->update([
            'name' => $this->name,
            'amount' => $this->amount,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.fdebitcategory.update', [
            'fdebitcategory' => $this->fdebitcategory
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('FdebitCategory') ])]);
    }
}
