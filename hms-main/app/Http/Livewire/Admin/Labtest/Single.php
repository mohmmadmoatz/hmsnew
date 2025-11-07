<?php

namespace App\Http\Livewire\Admin\Labtest;

use App\Models\LabTest;
use Livewire\Component;

class Single extends Component
{

    public $labtest;

    public function mount(LabTest $labtest){
        $this->labtest = $labtest;
    }

    public function delete()
    {
        $this->labtest->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('LabTest') ]) ]);
        $this->emit('labtestDeleted');
    }

    public function render()
    {
        return view('livewire.admin.labtest.single')
            ->layout('admin::layouts.app');
    }
}
