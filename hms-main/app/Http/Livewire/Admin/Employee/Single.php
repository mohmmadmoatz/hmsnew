<?php

namespace App\Http\Livewire\Admin\Employee;

use App\Models\Employee;
use Livewire\Component;

class Single extends Component
{

    public $employee;

    public function mount(Employee $employee){
        $this->employee = $employee;
    }

    public function delete()
    {
        $this->employee->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Employee') ]) ]);
        $this->emit('employeeDeleted');
    }

    public function render()
    {
        return view('livewire.admin.employee.single')
            ->layout('admin::layouts.app');
    }
}
