<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Models\Setting;
use Livewire\Component;

class Single extends Component
{

    public $setting;

    public function mount(Setting $setting){
        $this->setting = $setting;
    }

    public function delete()
    {
        $this->setting->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Setting') ]) ]);
        $this->emit('settingDeleted');
    }

    public function render()
    {
        return view('livewire.admin.setting.single')
            ->layout('admin::layouts.app');
    }
}
