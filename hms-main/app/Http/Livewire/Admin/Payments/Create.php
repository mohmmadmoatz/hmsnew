<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\Stage;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Patient;
use App\Models\User;
use App\Models\OperationHold;
use App\Models\Redirect;

class Create extends Component
{
    use WithFileUploads;

    public $payment_type =1;
    public $amount_usd = 0;
    public $amount_iqd =0;
    public $patinet_id;
    public $account_id;
    public $account_type;
    public $description;
    public $addnew = false;
    public $route;
    public $return_price;
    public $return_id;
    public $wasl_number;
    public $daterange;
    public $payto;
    public $total_amount;
    public $redirect;
    public $redirect_doctor_price;
    public $redirect_nurse_price;
    public $redirect_doctor_id;
    public $paydoctor;
    public $stname;
    public $stid;
    public $date;
    public $searchpat;
    public $rid;

    public $patinfo;
    public $selected =false;

    protected $queryString = ['payment_type','account_type','account_id','amount_iqd','daterange','payto','redirect','stname','stid','redirect_doctor_id','paydoctor','date','rid'];

    
    protected $rules = [

        'payment_type' => 'required',        'amount_usd' => 'required', 'amount_iqd' => 'required',       
              
        'account_type' => 'required',        


    ];


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

    public function selectpat($id)
    {
        $this->patinfo = Patient::find($id);
        $this->selected = true;
        $this->patinet_id = $id;
        $this->account_id = $id;
    }

    public function clear()
    {
        $this->patinfo = "";
        $this->selected = false;
        $this->patinet_id = "";
    }

    public function initDirect()
    {
        if($this->redirect){

        
        if($this->redirect !=2)
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

    public function mount()
    {

        $setting = Setting::find(1);
        

        $this->date = date("Y-m-d");
        
        if($this->payment_type == 1){
            $this->wasl_number=$setting->wasl_no;
        }

        if($this->payment_type == 2){
            $this->wasl_number=$setting->income_no;
        }
        
        


        if($this->redirect){
            $this->initDirect();
        }
        if($this->redirect_doctor_id){
            $this->changeDoctor();
        }
        if($this->daterange){
            $this->total_amount = $this->amount_iqd;
          
            if($this->paydoctor){
                $this->account_type =1;
                $this->account_id = $this->paydoctor;
            }

            $this->description = "اجور العمليات للفترة  : " . $this->daterange;
            if($this->stname){
            $this->description = "اجور $this->stname للفترة  : " . $this->daterange;
            }
        }

        

        $this->route = url()->previous();
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    

    public function create($print=null)
    {

        // check if wasl number is already exist based on payment_type

        $payment = Payments::where("wasl_number",$this->wasl_number)
        ->where("payment_type",$this->payment_type)->first();


        // if($payment){
        //     $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "رقم الوصل موجود بالفعل"]);
        //     return;
        // }
        


        if(!$this->amount_iqd){
            $this->amount_iqd =0;
        }

        if(!$this->amount_usd){
            $this->amount_usd =0;
        }
     

        $return_iqd =0;
        $return_usd =0;

        if($this->payment_type ==2){
        if($this->amount_iqd < 0){
            $return_iqd = $this->amount_iqd * -1;
            $this->amount_iqd=0;
        }

        if($this->amount_usd < 0){
            $return_usd = $this->amount_usd * -1;
            $this->amount_usd=0;
        }
    }

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Payments') ])]);

        if(!$this->redirect_doctor_id){
            $this->redirect_doctor_price = 0;
        }

        if($this->redirect == 1){
            if(!$this->redirect_doctor_id){
                $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "يرجى اختيار الطبيب"]);
               return;
            }
        }

        $data =[
        'payment_type' => $this->payment_type,
        'amount_usd' => $this->amount_usd,
        'amount_iqd' => $this->amount_iqd,
        'redirect_doctor_price' => $this->redirect_doctor_price,
        'redirect_doctor_id' => $this->redirect_doctor_id,
        'redirect_nurse_price' => $this->redirect_nurse_price,
        'account_type' => $this->account_type,
        'description' => $this->description,
        'user_id' => auth()->id(),
        "wasl_number"=>$this->wasl_number,
        "redirect"=>$this->redirect,
        "return_iqd"=>$return_iqd,
        "return_usd"=>$return_usd,
        'date'=>$this->date
    ];

  


        if($this->account_type == 1){
            $data['doctor_id'] = $this->account_id;
        }else if($this->account_type ==2){
            
            $data['patinet_id'] = $this->account_id;    
            $patdata = Patient::find($this->account_id);
            $patdata->paid =1;
            $patdata->save();

            if($this->rid){
                $rd = Redirect::find($this->rid);
                $rd->paid=1;
                $rd->save();
                $data['rid']=$rd->id;   
            }

        }else if($this->account_type ==3){
            $data['account_name'] = $this->account_id;
        }

        if($this->stname){
            $data['is_stage']=$this->stid;
        }

          $printid =   Payments::create($data);

        $setting = Setting::find(1);

        if($this->payment_type == 1){
            $setting->wasl_no = $setting->wasl_no + 1;
        }

        if($this->payment_type == 2){
            $setting->income_no = $setting->income_no + 1;
        }
        $setting->save();
            
     
      
        if($this->daterange){
            $data = OperationHold::query();
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);

            $dataPay = Payments::query();
            
            $dataPay = $dataPay->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
           
        if($this->payto =="doctor"){

            $data = $data->where("doctor_id",$this->account_id);
            $data->update([
                "doctor_paid"=>1
            ]);
        }elseif ($this->payto =="helper") {
            $data = $data->whereNull("helper_paid");
            $data->update([
                "helper_paid"=>1
            ]);
        }elseif ($this->payto =="helperm5dr") {
            $data = $data->whereNull("helperm5dr_paid");
            $data->update([
                "helperm5dr_paid"=>1
        ]);
        }elseif ($this->payto =="qabla") {
            $data = $data->whereNull("qabla_paid");
            $data->update([
                "qabla_paid"=>1
            ]);
        }elseif ($this->payto =="m5dr") {
            $data = $data->whereNull("m5dr_paid")->whereNotNull("m5dr_selected");
            $data->update([
                "m5dr_paid"=>1
            ]);
        }elseif ($this->payto =="mqema") {
            $data = $data->whereNull("mqema_paid");
            $data->update([
                "mqema_paid"=>1
            ]);
        }
        elseif ($this->payto =="nurse") {
            $data = $data->whereNull("nurse_paid");
            $data->update([
                "nurse_paid"=>1
            ]);
        }
        elseif ($this->payto =="ambulance") {
            $data = $data->whereNull("ambulance_paid")->where("ambulance_doctor",$this->account_id);
            $data->update([
                "ambulance_paid"=>1
            ]);
        }

        elseif ($this->payto =="doctorfromstage") {

            $dataPay = $dataPay->whereNull("redirect_doctor_paid");
            if($this->paydoctor){
                $dataPay = $dataPay->where("redirect_doctor_id",$this->paydoctor);
            }
            $dataPay->update([
                "redirect_doctor_paid"=>1
            ]);
        }  elseif ($this->payto =="nursefromstage") {
            $dataPay = $dataPay->whereNull("redirect_nurse_paid");
            $dataPay->update([
                "redirect_nurse_paid"=>1
            ]);
        }



        

    }


        if($this->return_id){
            $operation = OperationHold::where("payment_number",$this->return_id)->first();

            if($operation){
                $updateOpeartion = OperationHold::find($operation->id);
                if($this->payment_type == 2){
                $updateOpeartion->operation_price = $updateOpeartion->operation_price + $this->amount_iqd;

                }else{
                    $updateOpeartion->operation_price = $updateOpeartion->operation_price - $this->amount_iqd;

                }
                $updateOpeartion->doctorexp = ($updateOpeartion->nsba / 100) * $updateOpeartion->operation_price;
                $updateOpeartion->save();
            }
        }

       
        if($print){
          
        return  redirect(route("printrecept") . "?id=$printid->id");

           
        }

        return  redirect($this->route);

    }

    public function render()
    {
    
        
        return view('livewire.admin.payments.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Payments') ])]);
    }
}
