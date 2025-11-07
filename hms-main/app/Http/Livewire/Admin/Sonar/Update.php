<?php

namespace App\Http\Livewire\Admin\Sonar;

use App\Models\Sonar;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $sonar;

    public $patient_id;
    public $notes;
    public $image;
    
    protected $rules = [
        
    ];

    public function mount(Sonar $sonar){
        $this->sonar = $sonar;
        $this->patient_id = $this->sonar->patient_id;
        $this->notes = $this->sonar->notes;
        $this->image = $this->sonar->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Sonar') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        $this->sonar->update([
            'patient_id' => $this->patient_id,
            'notes' => $this->notes,
            'image' => $this->image,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.sonar.update', [
            'sonar' => $this->sonar
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Sonar') ])]);
    }
}
