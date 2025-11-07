<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $room;

    public $name;
    public $patient_id;
    public $floor;
    public $note;
    public $image;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Room $room){
        $this->room = $room;
        $this->name = $this->room->name;
        $this->patient_id = $this->room->patient_id;
        $this->floor = $this->room->floor;
        $this->note = $this->room->note;
        $this->image = $this->room->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Room') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        $this->room->update([
            'name' => $this->name,
            'patient_id' => $this->patient_id,
            'floor' => $this->floor,
            'notes' => $this->note,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.room.update', [
            'room' => $this->room
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Room') ])]);
    }
}
