<?php

namespace App\Http\Livewire\Admin\Debitaccount;

use App\Models\DebitAccount;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $debitaccount;

    public $name;
    public $notes;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(DebitAccount $debitaccount){
        $this->debitaccount = $debitaccount;
        $this->name = $this->debitaccount->name;
        $this->notes = $this->debitaccount->notes;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('DebitAccount') ]) ]);
        
        $this->debitaccount->update([
            'name' => $this->name,
            'notes' => $this->notes,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.debitaccount.update', [
            'debitaccount' => $this->debitaccount
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('DebitAccount') ])]);
    }
}
