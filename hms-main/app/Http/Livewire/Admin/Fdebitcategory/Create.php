<?php

namespace App\Http\Livewire\Admin\Fdebitcategory;

use App\Models\FdebitCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $amount;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('FdebitCategory') ])]);
        
        FdebitCategory::create([
            'name' => $this->name,
            'amount' => $this->amount,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.fdebitcategory.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('FdebitCategory') ])]);
    }
}
