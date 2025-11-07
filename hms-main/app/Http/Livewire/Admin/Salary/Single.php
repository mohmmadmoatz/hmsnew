<?php

namespace App\Http\Livewire\Admin\Salary;

use App\Models\Salary;
use Livewire\Component;

class Single extends Component
{

    public $salary;

    public function mount(Salary $salary){
        $this->salary = $salary;
    }

    public function delete()
    {
        $this->salary->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Salary') ]) ]);
        $this->emit('salaryDeleted');
    }

    public function render()
    {
        return view('livewire.admin.salary.single')
            ->layout('admin::layouts.app');
    }
}
