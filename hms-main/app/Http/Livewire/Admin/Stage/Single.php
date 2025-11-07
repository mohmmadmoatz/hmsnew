<?php

namespace App\Http\Livewire\Admin\Stage;

use App\Models\Stage;
use Livewire\Component;

class Single extends Component
{

    public $stage;

    public function mount(Stage $stage){
        $this->stage = $stage;
    }

    public function delete()
    {
        $this->stage->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Stage') ]) ]);
        $this->emit('stageDeleted');
    }

    public function render()
    {
        return view('livewire.admin.stage.single')
            ->layout('admin::layouts.app');
    }
}
