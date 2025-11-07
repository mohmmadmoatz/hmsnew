<?php

namespace App\Http\Livewire\Admin\Stocksup;

use App\Models\Stocksup;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $notes;
    public $type;
    
    protected $rules = [
        'name' => 'required',        'type' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Stocksup') ])]);
        
        Stocksup::create([
            'name' => $this->name,            'notes' => $this->notes,
            'type' => $this->type,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.stocksup.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Stocksup') ])]);
    }
}
