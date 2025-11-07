<?php

namespace App\Http\Livewire\Admin\Saveaccount;

use App\Models\Saveaccount;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $saveaccount;

    public $type;
    public $amount_iqd;
    public $amount_usd;
    public $date;
    public $details;
    
    protected $rules = [
        'type' => 'required',        'amount_iqd' => 'required',        'amount_usd' => 'required',        'date' => 'required',        
    ];

    public function mount(Saveaccount $saveaccount){
        $this->saveaccount = $saveaccount;
        $this->type = $this->saveaccount->type;
        $this->amount_iqd = $this->saveaccount->amount_iqd;
        $this->amount_usd = $this->saveaccount->amount_usd;
        $this->date = $this->saveaccount->date;
        $this->details = $this->saveaccount->details;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Saveaccount') ]) ]);
        


        $this->saveaccount->update([
            'type' => $this->type,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'date' => $this->date,
            'details' => $this->details,
            'user_id' => auth()->id(),
        ]);

        


       
    }

    public function render()
    {
        return view('livewire.admin.saveaccount.update', [
            'saveaccount' => $this->saveaccount
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Saveaccount') ])]);
    }
}
