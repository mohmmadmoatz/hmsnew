<?php

namespace App\Http\Livewire\Admin\Rays;

use App\Models\Rays;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $rays;

    public $patient_id;
    public $notes;
    public $image;
    
    protected $rules = [
        'patient_id' => 'required' 
    ];

    public function mount(Rays $rays){
        $this->rays = $rays;
        $this->patient_id = $this->rays->patient_id;
        $this->notes = $this->rays->notes;
        $this->image = $this->rays->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Rays') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/xrays','public');
        }

        $this->rays->update([
            'patient_id' => $this->patient_id,
            'notes' => $this->notes,
            'image' => $this->image,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.rays.update', [
            'rays' => $this->rays
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Rays') ])]);
    }
}
