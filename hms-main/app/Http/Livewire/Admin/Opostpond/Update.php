<?php

namespace App\Http\Livewire\Admin\Opostpond;

use App\Models\Opostpond;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $opostpond;

    public $operationhold_id;
    public $date;
    public $reason;
    
    protected $rules = [
        'date' => 'required',
        'reason' => 'required|min:30',        
    ];

    public function mount(Opostpond $opostpond){
        $this->opostpond = $opostpond;
        $this->operationhold_id = $this->opostpond->operationhold_id;
        $this->date = $this->opostpond->date;
        $this->reason = $this->opostpond->reason;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Opostpond') ]) ]);
        
        $this->opostpond->update([
            'operationhold_id' => $this->operationhold_id,
            'date' => $this->date,
            'reason' => $this->reason,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.opostpond.update', [
            'opostpond' => $this->opostpond
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Opostpond') ])]);
    }
}
