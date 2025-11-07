<?php

namespace App\Http\Livewire\Admin\Bank;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $bank;

    public $wasl_number;
    public $description;
    public $amount_iqd;
    public $amount_usd;
    public $date;
    
    protected $rules = [
        'wasl_number' => 'required',        'description' => 'required',        
    ];

    public function mount(Bank $bank){
        $this->bank = $bank;
        $this->wasl_number = $this->bank->wasl_number;
        $this->description = $this->bank->description;
        $this->amount_iqd = $this->bank->amount_iqd;
        $this->amount_usd = $this->bank->amount_usd;
        $this->date = $this->bank->date;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Bank') ]) ]);
        
        $this->bank->update([
            'wasl_number' => $this->wasl_number,
            'description' => $this->description,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'date' => $this->date,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bank.update', [
            'bank' => $this->bank
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Bank') ])]);
    }
}
