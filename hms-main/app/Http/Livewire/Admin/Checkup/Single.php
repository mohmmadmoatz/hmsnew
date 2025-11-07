<?php

namespace App\Http\Livewire\Admin\Checkup;

use App\Models\Checkup;
use Livewire\Component;

class Single extends Component
{

    public $checkup;

    public function mount(Checkup $checkup){
        $this->checkup = $checkup;
    }

    public function delete()
    {
        $this->checkup->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Checkup') ]) ]);
        $this->emit('checkupDeleted');
    }

    public function render()
    {
        return view('livewire.admin.checkup.single')
            ->layout('admin::layouts.app');
    }
}
