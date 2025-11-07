<?php

namespace App\Http\Livewire\Admin\Clinic;

use App\Models\Clinic;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $clinic;

    public $name;
    public $doctor_id;
    public $image;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Clinic $clinic){
        $this->clinic = $clinic;
        $this->name = $this->clinic->name;
        $this->doctor_id = $this->clinic->doctor_id;
        // $this->image = $this->clinic->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        // $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Clinic') ]) ]);
        
        // if($this->getPropertyValue('image') and is_object($this->image)) {
        //     $this->image = $this->getPropertyValue('image')->store('images/articles');
        // }

        $this->clinic->update([
            'name' => $this->name,
            'doctor_id' => $this->doctor_id,
            // 'image' => $this->image,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.clinic.update', [
            'clinic' => $this->clinic
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Clinic') ])]);
    }
}
