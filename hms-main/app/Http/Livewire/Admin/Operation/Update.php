<?php

namespace App\Http\Livewire\Admin\Operation;

use App\Models\Operation;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $operation;

    public $name;
    public $price;
    public $notes;
    
    protected $rules = [
        'name' => 'required',        'price' => 'required',        
    ];

    public function mount(Operation $operation){
        $this->operation = $operation;
        $this->name = $this->operation->name;
        $this->price = $this->operation->price;
        $this->notes = $this->operation->notes;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Operation') ]) ]);
        
        $this->operation->update([
            'name' => $this->name,
            'price' => $this->price,
            'notes' => $this->notes,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.operation.update', [
            'operation' => $this->operation
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Operation') ])]);
    }
}
