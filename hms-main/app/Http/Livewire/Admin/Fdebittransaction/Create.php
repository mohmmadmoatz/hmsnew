<?php

namespace App\Http\Livewire\Admin\Fdebittransaction;

use App\Models\FdebitTransaction;
use App\Models\FdebitCategory;
use App\Models\Payments;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function updatedCategoryId($value)
    {
        if($value)
        $this->amount_iqd = FdebitCategory::find($value)->amount ?? 0;  
        else
        $this->amount_iqd = 0;
    }

    public function create()
    {

        $this->wasl_number=Payments::withTrashed()->where("payment_type",1)->max("wasl_number") + 1;

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('FdebitTransaction') ])]);
        
        $fdebit =  FdebitTransaction::create([
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


        //create another in payments table

        $payment = Payments::create([
            'payment_type' => 1,
            'amount_usd' => $this->amount_usd,
            'amount_iqd' => $this->amount_iqd,
            'wasl_number' => $this->wasl_number,
            'account_type'=>3,
            'account_name'=>$this->name,
            'description' => $this->notes,
            'date' => $this->date,
            'user_id' => auth()->id(),
            'fdebit_id' => $fdebit->id,
        ]);

        

        $fdebit->update([
            'payment_id' => $payment->id,
        ]);

        
        $this->reset();


    }

    public function render()
    {
        return view('livewire.admin.fdebittransaction.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('FdebitTransaction') ])]);
    }
}
