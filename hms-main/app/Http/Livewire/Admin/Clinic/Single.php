<?php

namespace App\Http\Livewire\Admin\Clinic;

use App\Models\Clinic;
use Livewire\Component;

class Single extends Component
{

    public $clinic;

    public function mount(Clinic $clinic){
        $this->clinic = $clinic;
    }

    public function delete()
    {
        $this->clinic->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Clinic') ]) ]);
        $this->emit('clinicDeleted');
    }

    public function render()
    {
        return view('livewire.admin.clinic.single')
            ->layout('admin::layouts.app');
    }
}
