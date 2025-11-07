<?php

namespace App\Http\Livewire\Admin\Empadvance;

use App\Models\Empadvance;
use Livewire\Component;

class Single extends Component
{

    public $empadvance;

    public function mount(Empadvance $empadvance){
        $this->empadvance = $empadvance;
    }

    public function delete()
    {
        $this->empadvance->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Empadvance') ]) ]);
        $this->emit('empadvanceDeleted');
    }

    public function render()
    {
        return view('livewire.admin.empadvance.single')
            ->layout('admin::layouts.app');
    }
}
