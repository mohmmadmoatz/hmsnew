<?php

namespace App\Http\Livewire\Admin\Clinic;

use App\Models\Clinic;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $doctor_id;
    public $image;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        // $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Clinic') ])]);
        
        // if($this->getPropertyValue('image') and is_object($this->image)) {
        //     $this->image = $this->getPropertyValue('image')->store('images/articles');
        // }

        Clinic::create([
            'name' => $this->name,
            'doctor_id' => $this->doctor_id,
            // 'image' => $this->image,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.clinic.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Clinic') ])]);
    }
}
