<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\Setting;
use App\Models\OperationHold;
use App\Models\User;
use App\Models\Patient;
use App\Models\Stage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $payments;

    public $payment_type;
    public $amount_usd;
    public $amount_iqd;
    public $patinet_id;
    public $description;
    public $account_type;
    public $redirect;
    public $redirect_doctor_price;
    public $redirect_nurse_price;
    public $redirect_doctor_id;
   
    public $operation_price;
    public $operation_profile;
    public $operation_doctor;
    public $operation_id;
    public $operation_name;
    public $operation_nsba;

    public $wasl_number;

    protected $rules = [
        'payment_type' => 'required',        'amount_usd' => 'required', 'amount_iqd' => 'required',        
    ];

    public function initDirect()
    {
        if($this->redirect){

        
        $this->amount_iqd = Stage::find($this->redirect)->total_price;
        if($this->redirect_doctor_id){
            $doctor_id=$this->redirect_doctor_id;
        }else{
        $doctor_id = Stage::find($this->redirect)->doctor_id;

        }
        $doctor = User::find($doctor_id);

        $this->redirect_doctor_id = $doctor_id;
        $this->redirect_doctor_price = Stage::find($this->redirect)->doctor_price;

        if($doctor){    
        if($doctor->user_type == "doctor"){
            $this->redirect_doctor_price = Stage::find($this->redirect)->doctor_price;

        }else{
            $this->redirect_doctor_price = Stage::find($this->redirect)->res_price;
        }
    }

        $this->redirect_nurse_price = Stage::find($this->redirect)->other_price;

    }
    }

    public function changeDoctor()
    {
        $doctor = User::find($this->redirect_doctor_id);
        
        
        if($doctor){    
            if($doctor->user_type == "doctor" || $doctor->user_type =="rays"){
                $this->redirect_doctor_price = Stage::find($this->redirect)->doctor_price;
    
            }else{
                $this->redirect_doctor_price = Stage::find($this->redirect)->res_price;
            }
        }
        
    }

    public function mount(Payments $payments){
        $this->payments = $payments;
        $this->payment_type = $this->payments->payment_type;
        $this->amount_usd = $this->payments->amount_usd;
        $this->amount_iqd = $this->payments->amount_iqd;
        $this->patinet_id = $this->payments->patinet_id;
        $this->description = $this->payments->description;
        $this->account_type = $this->payments->account_type;
        $this->date = $this->payments->date;      
        $this->redirect = $this->payments->redirect; 

        $this->redirect_doctor_price = $this->payments->redirect_doctor_price;  
        $this->redirect_nurse_price = $this->payments->redirect_nurse_price;  
        $this->redirect_doctor_id = $this->payments->redirect_doctor_id;  

        $this->operation_price = $this->payments->operation_price;  
        $this->operation_profile = $this->payments->operation_profile;  
        $this->operation_doctor = $this->payments->operation_profile; 
        $this->operation_id = $this->payments->operation_id; 
        
        $this->operation_nsba = $this->payments->operation_nsba; 
        $this->operation_name = $this->payments->operation_name; 
        $this->wasl_number = $this->payments->wasl_number; 

    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {

        if(!$this->amount_iqd){
            $this->amount_iqd =0;
        }

        if(!$this->amount_usd){
            $this->amount_usd =0;
        }

        if(!$this->amount_iqd){
            $this->amount_iqd =0;
        }

        if(!$this->amount_usd){
            $this->amount_usd =0;
        }
        
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Payments') ]) ]);
        
        $this->payments->update([
            'payment_type' => $this->payment_type,
            'amount_usd' => $this->amount_usd,
            'amount_iqd' => $this->amount_iqd,
            'description' => $this->description,
            "redirect"=>$this->redirect,
            'redirect_doctor_price' => $this->redirect_doctor_price,
            'redirect_doctor_id' => $this->redirect_doctor_id,
            'redirect_nurse_price' => $this->redirect_nurse_price,
            'operation_price' => $this->operation_price,
            'operation_profile' => $this->operation_profile,
            'operation_doctor' => $this->operation_doctor,
            'wasl_number' => $this->wasl_number,
            'user_id' => auth()->id(),
        ]);

        if($this->operation_id){
            $updateOperation = OperationHold::find($this->operation_id);
            $setting = Setting::find(1);
            $patient = Patient::find($this->patinet_id);
            if($this->operation_name == "ولادة طبيعية"){
                if($this->operation_nsba ==60){
                    if($this->operation_price >= 600000){
                        $doctorexp = ($this->operation_price) * ($this->operation_nsba / 100);
                    }else{
                        $doctorexp = 0;
                    }
                }else{
                    $doctorexp = 0;
                }
            }else{
        
                $opPrice = ($this->operation_price);
        
                $doctorexp =($this->operation_price) * ($this->operation_nsba / 100);
        
        
                if($this->operation_nsba  == 60 && $this->operation_name =="ولادة قيصرية"){
                if($opPrice < $setting->min_op_price){
                    $fixedNsba = $setting->min_op_price * ($setting->hnsba  / 100);
                    $doctorexp = abs($opPrice - $fixedNsba);
                }
            }elseif ($opPrice < $patient->operation->price) {

                if($opPrice <= 200000){
                    $doctorexp = $opPrice / 2;
                }else{
                    $fixedNsba = $patient->operation->price * ($setting->hnsba  / 100);
                    $doctorexp = abs($opPrice - $fixedNsba);
                }
         
            }
        
                $nurse_price=$setting->nurse_price;
        
            }

            
            $updateOperation->operation_price = $this->operation_price;
            $updateOperation->doctorexp = $doctorexp;
            $updateOperation->nsba = $this->operation_nsba;
            $updateOperation->save();

        }
    }

    public function render()
    {
        
        if($this->payments->operation_id !=null){
           // $this->amount_iqd = $this->operation_price + $this->operation_profile;
        }

        return view('livewire.admin.payments.update', [
            'payments' => $this->payments
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Payments') ])]);
    }
}
