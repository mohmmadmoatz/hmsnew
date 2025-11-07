<?php

namespace App\Http\Livewire\Admin\Empcategory;

use App\Models\EmpCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $empcategory;

    public $name;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(EmpCategory $empcategory){
        $this->empcategory = $empcategory;
        $this->name = $this->empcategory->name;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('EmpCategory') ]) ]);
        
        $this->empcategory->update([
            'name' => $this->name,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.empcategory.update', [
            'empcategory' => $this->empcategory
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('EmpCategory') ])]);
    }
}
