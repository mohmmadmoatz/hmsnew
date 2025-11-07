<?php

namespace App\Http\Livewire\Admin\Cashaccount;

use App\Models\Cashaccount;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $cashaccount;

    public $name;
    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Cashaccount $cashaccount){
        $this->cashaccount = $cashaccount;
        $this->name = $this->cashaccount->name;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Cashaccount') ]) ]);
        
        $this->cashaccount->update([
            'name' => $this->name,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.cashaccount.update', [
            'cashaccount' => $this->cashaccount
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Cashaccount') ])]);
    }
}
