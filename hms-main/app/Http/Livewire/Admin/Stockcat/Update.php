<?php

namespace App\Http\Livewire\Admin\Stockcat;

use App\Models\Stockcat;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $stockcat;

    public $name;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Stockcat $stockcat){
        $this->stockcat = $stockcat;
        $this->name = $this->stockcat->name;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Stockcat') ]) ]);
        
        $this->stockcat->update([
            'name' => $this->name,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stockcat.update', [
            'stockcat' => $this->stockcat
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Stockcat') ])]);
    }
}
