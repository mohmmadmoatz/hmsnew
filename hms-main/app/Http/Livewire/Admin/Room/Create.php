<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $patient_id;
    public $floor;
    public $note;
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
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Room') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        Room::create([
            'name' => $this->name,
            'patient_id' => $this->patient_id,
            'floor' => $this->floor,
            'notes' => $this->note,
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.room.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Room') ])]);
    }
}
