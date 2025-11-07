<?php

namespace App\Http\Livewire\Admin\Stocksup;

use App\Models\Stocksup;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $stocksup;

    public $name;
    public $notes;
    public $type;
    
    protected $rules = [
        'name' => 'required',        'type' => 'required',        
    ];

    public function mount(Stocksup $stocksup){
        $this->stocksup = $stocksup;
        $this->name = $this->stocksup->name;
        $this->notes = $this->stocksup->notes;
        $this->type = $this->stocksup->type;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Stocksup') ]) ]);
        
        $this->stocksup->update([
            'name' => $this->name,            'notes' => $this->notes,
            'type' => $this->type,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stocksup.update', [
            'stocksup' => $this->stocksup
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Stocksup') ])]);
    }
}
