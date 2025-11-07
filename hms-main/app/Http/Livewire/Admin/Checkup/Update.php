<?php

namespace App\Http\Livewire\Admin\Checkup;

use App\Models\Checkup;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $checkup;

    public $note;
    public $image;
    
    protected $rules = [
        'image' => 'required',        
    ];

    public function mount(Checkup $checkup){
        $this->checkup = $checkup;
        $this->note = $this->checkup->note;
        $this->image = $this->checkup->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Checkup') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/clc','public');
        }

        $this->checkup->update([
            'notes' => $this->note,
            'image' => $this->image,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.checkup.update', [
            'checkup' => $this->checkup
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Checkup') ])]);
    }
}
