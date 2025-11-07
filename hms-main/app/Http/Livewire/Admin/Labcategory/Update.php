<?php

namespace App\Http\Livewire\Admin\Labcategory;

use App\Models\LabCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $labcategory;

    public $name;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(LabCategory $labcategory){
        $this->labcategory = $labcategory;
        $this->name = $this->labcategory->name;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('LabCategory') ]) ]);
        
        $this->labcategory->update([
            'name' => $this->name,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.labcategory.update', [
            'labcategory' => $this->labcategory
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('LabCategory') ])]);
    }
}
