<?php

namespace App\Http\Livewire\Admin\Patient;

use App\Models\Patient;
use App\Models\Room;
use Livewire\Component;

class Single extends Component
{

    public $patient;

    public function mount(Patient $patient){
        $this->patient = $patient;
    }

    public function checkout()
    {
        $room = Room::find($this->patient->room_id);
        $room->patient_id =0;
        $room->save();
        $this->patient->room_id = 0;
        $this->patient->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => 'تم اخراج المريض بنجاح' ]);

    }

    public function delete()
    {
        $this->patient->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Patient') ]) ]);
        $this->emit('patientDeleted');
    }

    public function render()
    {
        return view('livewire.admin.patient.single')
            ->layout('admin::layouts.app');
    }
}
