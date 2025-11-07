<?php

namespace App\Http\Livewire\Admin\Sonar;

use App\Models\Sonar;
use Livewire\Component;

class Single extends Component
{

    public $sonar;

    public function mount(Sonar $sonar){
        $this->sonar = $sonar;
    }

    public function delete()
    {
        $this->sonar->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Sonar') ]) ]);
        $this->emit('sonarDeleted');
    }

    public function render()
    {
        return view('livewire.admin.sonar.single')
            ->layout('admin::layouts.app');
    }
}
