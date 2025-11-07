<?php

namespace App\Http\Livewire\Admin\Saveaccount;

use App\Models\Saveaccount;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Payments;
class Create extends Component
{
    use WithFileUploads;

    public $type;
    public $amount_iqd;
    public $amount_usd;
    public $date;
    public $details;
    public $wasl_number;
    
    protected $rules = [
        'type' => 'required',        'amount_iqd' => 'required',        'amount_usd' => 'required',        'date' => 'required',        
    ];

    public function mount()
    {
        $this->date = date("Y-m-d");
        $this->wasl_number=Payments::withTrashed()->where("payment_type","1")->max("wasl_number") + 1;
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Saveaccount') ])]);
        
        $wasl = Saveaccount::create([
            'type' => $this->type,
            'amount_iqd' => $this->amount_iqd,
            'amount_usd' => $this->amount_usd,
            'date' => $this->date,
            'details' => $this->details,
            'wasl_number' => $this->wasl_number,
            'user_id' => auth()->id(),
        ]);

        // create payment if type is withdraw
      if($this->type == "2"){
        $pay = Payments::create([
        'amount_usd' => $this->amount_usd,
        'amount_iqd' => $this->amount_iqd,
        'date' => $this->date,
        'description' => $this->details,
        'wasl_number' => $this->wasl_number,
        'user_id' => auth()->id(),
        "account_type"=>3,
        "account_name"=>"الحساب الاحتياطي",
        'payment_type'=>1
        ]);

        $wasl->payment_number = $pay->id;
    }


        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.saveaccount.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Saveaccount') ])]);
    }
}
