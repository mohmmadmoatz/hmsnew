<?php

namespace App\Http\Livewire\Admin\Debittransaction;

use App\Models\DebitTransaction;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $debittransaction;

    public $number;
    public $date;
    public $amount_iqd;
    public $amount_usd;
    public $name;
    public $notes;
    public $payment_type;
    public $file;
    public $account_id;
    
    protected $rules = [
        'date' => 'required',        'amount_iqd' => 'required',        'amount_usd' => 'required',        'name' => 'required',        
    ];

    public function mount(DebitTransaction $debittransaction){
        $this->debittransaction = $debittransaction;
        $this->number = $this->debittransaction->number;
        $this->date = $this->debittransaction->date;
        $this->amount_iqd = $this->debittransaction->amount_iqd;
        $this->amount_usd = $this->debittransaction->amount_usd;
        $this->name = $this->debittransaction->name;
        $this->notes = $this->debittransaction->notes;
        $this->payment_type = $this->debittransaction->payment_type;
        $this->file = $this->debittransaction->file;
        $this->account_id = $this->debittransaction->account_id;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('DebitTransaction') ]) ]);
        
        if($this->getPropertyValue('file') and is_object($this->file)) {
            $this->file = $this->getPropertyValue('file')->store('images/debit');
        }

        $this->debittransaction->update([
            'number' => $this->number,
            'date' => $this->date,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'name' => $this->name,
            'notes' => $this->notes,
            'payment_type' => $this->payment_type,
            'file' => $this->file,
            'account_id' => $this->account_id,
            'user_id' => auth()->id(),
        ]);

        if($this->payment_type == 1) {
            $payment = Payments::find($this->debittransaction->payment_id);
            $payment->update([
                'amount_usd' => $this->amount_usd,
                'amount_iqd' => $this->amount_iqd,
            ]);
        }

    }

    public function render()
    {
        return view('livewire.admin.debittransaction.update', [
            'debittransaction' => $this->debittransaction
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('DebitTransaction') ])]);
    }
}
