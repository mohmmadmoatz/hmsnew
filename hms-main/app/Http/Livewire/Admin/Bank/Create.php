<?php

namespace App\Http\Livewire\Admin\Bank;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $wasl_number;
    public $description;
    public $amount_iqd;
    public $amount_usd;
    public $date;
    
    protected $rules = [
        'wasl_number' => 'required',        'description' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Bank') ])]);
        
        Bank::create([
            'wasl_number' => $this->wasl_number,
            'description' => $this->description,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'date' => $this->date,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.bank.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Bank') ])]);
    }
}
