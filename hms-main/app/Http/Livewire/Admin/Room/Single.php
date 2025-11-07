<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Livewire\Component;

class Single extends Component
{

    public $room;

    public function mount(Room $room){
        $this->room = $room;
    }

    public function delete()
    {
        $this->room->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Room') ]) ]);
        $this->emit('roomDeleted');
    }

    public function render()
    {
        return view('livewire.admin.room.single')
            ->layout('admin::layouts.app');
    }
}
