<?php

namespace App\Http\Livewire\Admin\Unit;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $unit;

    public $name;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Unit $unit){
        $this->unit = $unit;
        $this->name = $this->unit->name;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Unit') ]) ]);
        
        $this->unit->update([
            'name' => $this->name,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.unit.update', [
            'unit' => $this->unit
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Unit') ])]);
    }
}
