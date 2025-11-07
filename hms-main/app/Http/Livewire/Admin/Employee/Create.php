<?php

namespace App\Http\Livewire\Admin\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $salary;
    public $notes;
    public $category_id;
    
    protected $rules = [
        'name' => 'required',        'salary' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Employee') ])]);
        
        Employee::create([
            'name' => $this->name,            'salary' => $this->salary,
            'notes' => $this->notes,          
            'category_id' => $this->category_id,  
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.employee.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Employee') ])]);
    }
}
