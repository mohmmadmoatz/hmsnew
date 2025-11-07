<?php

namespace App\Http\Livewire\Admin\Labsetting;

use App\Models\LabSetting;
use Livewire\Component;

class Single extends Component
{

    public $labsetting;

    public function mount(LabSetting $labsetting){
        $this->labsetting = $labsetting;
    }

    public function delete()
    {
        $this->labsetting->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('LabSetting') ]) ]);
        $this->emit('labsettingDeleted');
    }

    public function render()
    {
        return view('livewire.admin.labsetting.single')
            ->layout('admin::layouts.app');
    }
}
