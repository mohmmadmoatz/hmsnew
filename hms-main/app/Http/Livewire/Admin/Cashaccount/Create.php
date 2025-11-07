<?php

namespace App\Http\Livewire\Admin\Cashaccount;

use App\Models\Cashaccount;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    
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

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Cashaccount') ])]);
        
        Cashaccount::create([
            'name' => $this->name,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.cashaccount.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Cashaccount') ])]);
    }
}
