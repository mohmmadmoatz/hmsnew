<?php

namespace App\Http\Livewire\Admin\Operation;

use App\Models\Operation;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $price;
    public $notes;
    
    protected $rules = [
        'name' => 'required',        'price' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Operation') ])]);
        
        Operation::create([
            'name' => $this->name,
            'price' => $this->price,
            'notes' => $this->notes,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.operation.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Operation') ])]);
    }
}
