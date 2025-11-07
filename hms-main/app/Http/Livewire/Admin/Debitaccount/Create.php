<?php

namespace App\Http\Livewire\Admin\Debitaccount;

use App\Models\DebitAccount;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $notes;
    
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

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('DebitAccount') ])]);
        
        DebitAccount::create([
            'name' => $this->name,
            'notes' => $this->notes,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.debitaccount.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('DebitAccount') ])]);
    }
}
