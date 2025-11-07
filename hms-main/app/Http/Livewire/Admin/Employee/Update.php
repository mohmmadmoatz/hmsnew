<?php

namespace App\Http\Livewire\Admin\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $employee;

    public $name;
    public $salary;
    public $notes;
    public $category_id;

    
    protected $rules = [
        'name' => 'required',        'salary' => 'required',        
    ];

    public function mount(Employee $employee){
        $this->employee = $employee;
        $this->name = $this->employee->name;
        $this->salary = $this->employee->salary;
        $this->notes = $this->employee->notes; 
        $this->category_id = $this->employee->category_id;       
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Employee') ]) ]);
        
        $this->employee->update([
            'name' => $this->name,            'salary' => $this->salary,
            'notes' => $this->notes,
            'category_id' => $this->category_id,          
        ]);
    }

    public function render()
    {
        return view('livewire.admin.employee.update', [
            'employee' => $this->employee
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Employee') ])]);
    }
}
