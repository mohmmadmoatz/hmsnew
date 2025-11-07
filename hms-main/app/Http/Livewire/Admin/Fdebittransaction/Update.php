<?php

namespace App\Http\Livewire\Admin\Fdebittransaction;

use App\Models\FdebitTransaction;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Payments;


class Update extends Component
{
    use WithFileUploads;

    public $fdebittransaction;

    public $category_id;
    public $number;
    public $name;
    public $amount_iqd;
    public $amount_usd;
    public $exchange_rate;
    public $notes;
    public $date;
    
    protected $rules = [
        'category_id' => 'required',        'number' => 'required',        'date' => 'required',        
    ];

    public function mount(FdebitTransaction $fdebittransaction){
        $this->fdebittransaction = $fdebittransaction;
        $this->category_id = $this->fdebittransaction->category_id;
        $this->number = $this->fdebittransaction->number;
        $this->name = $this->fdebittransaction->name;
        $this->amount_iqd = $this->fdebittransaction->amount_iqd;
        $this->amount_usd = $this->fdebittransaction->amount_usd;
        $this->exchange_rate = $this->fdebittransaction->exchange_rate;
        $this->notes = $this->fdebittransaction->notes;
        $this->date = $this->fdebittransaction->date;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('FdebitTransaction') ]) ]);
        
        $this->fdebittransaction->update([
            'category_id' => $this->category_id,
            'number' => $this->number,
            'name' => $this->name,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'exchange_rate' => $this->exchange_rate,
            'notes' => $this->notes,
            'date' => $this->date,
            'user_id' => auth()->id(),
        ]);
    
        //update in payments table
        $payment = Payments::where('fdebit_id', $this->fdebittransaction->id)->first();
        $payment->update([
            'amount_usd' => $this->amount_usd,
            'amount_iqd' => $this->amount_iqd,
        ]);


    }


    public function render()
    {
        return view('livewire.admin.fdebittransaction.update', [
            'fdebittransaction' => $this->fdebittransaction
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('FdebitTransaction') ])]);
    }
}
