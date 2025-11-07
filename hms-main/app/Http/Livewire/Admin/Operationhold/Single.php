<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\OperationHold;
use Livewire\Component;
use App\Models\Payments;
use App\Models\Setting;
use App\Models\Patient;
use App\Models\Operation;
use App\Models\User;
class Single extends Component
{

    public $operationhold;
    public $optype;
    public $supervisedPrice;
    public $doctorexp;
    public $helperprice;
    public $helperm5dr;
    public $qabla;
    public $mqema_price;
    public $nurse_price;
    public $ambulance;
    public $ambulance_doctor;
    public $mqema_id;
    public $loop;
    public $income;
    public $wasl_number;
    public $nsba;
    protected $listeners = ['postAdded'];
    public $m5drprice;
    public $settings;
    public $doctors_res;
    public $outexp;

    public function postAdded(){
      
    }

    public function saveOutExp()
    {
            $this->operationhold->outexp = $this->outexp;
            $this->operationhold->save();

            $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم اضافة المصاريف الخارجية  " ]);
            $this->emit('postAdded');

    }

    public function updateNsba($value)
    {
      
        $this->nsba = $value;
        $this->doctorexp = $this->operationhold->operation_price * ($this->nsba / 100);

    }

    public function mount(OperationHold $operationhold,$loop,$doctors_res){
        $this->operationhold = $operationhold;
        $this->loop = $loop;
        $this->doctors_res = $doctors_res;
        $this->income = Operation::find(5)->price;
        $this->nsba = $this->operationhold->nsba;
        
    }

    public function loadNumberRecept()
    {
        $setting = Setting::find(1);
        
        $this->wasl_number= $setting->income_no;
        
    }

    public function convertToQ($id)
    {

        $converted = OperationHold::find($id);
        $setting = Setting::find(1);
        $converted->operation_name =  "ولادة قيصرية";
        $price = Operation::find(5)->price;
        



        $payment = Payments::where("id",$converted->payment_id)
        
        ->first();



        $patient_id = $converted->patinet_id;
        $patient = Patient::find($patient_id);
        $patient->opration_id = 5;

        // Convert Code

        $opPrice = ($this->income);

        $doctorexp =($this->income) * ($patient->hms_nsba / 100);

        if($patient->hms_nsba  >= 60){
            if($opPrice < $setting->min_op_price){
                $fixedNsba = $setting->min_op_price * ($setting->hnsba  / 100);
                $doctorexp = abs($opPrice - $fixedNsba);
            }
        }elseif ($opPrice < $price) {

            if($opPrice <= 200000){
                $doctorexp = $opPrice / 2;
            }else{
                $fixedNsba = $price * ($setting->hnsba  / 100);
                $doctorexp = abs($opPrice - $fixedNsba);
            }
        }

        $nurse_price=$setting->nurse_price;




        // Change Wasl Number

        $newPayment = $payment->replicate();
        $newPayment->operation_id = 5;
        $newPayment->operation_price = $opPrice;
        $newPayment->operation_name = "ولادة قيصرية";
        $newPayment->description = "اجور تحويل من ولادة طبيعية من الوصل : ".$payment->wasl_number; 
        $newPayment->amount_iqd = $this->income - $converted->operation_price;   
        $newPayment->amount_usd = 0;
        $newPayment->date = date("Y-m-d");
        $this->loadNumberRecept();
        $newPayment->wasl_number = $this->wasl_number;
        $newPayment->save();

        



        
        $converted->operation_price = $opPrice;
        $converted->doctorexp = $doctorexp;
        $converted->helper = $setting->helper_doctor;
        $converted->m5dr = $setting->m5dr_doctor;
        $converted->helperm5dr  = $setting->helper_m5dr_doctor;
        $patient->save();
        $converted->save();

        $setting->income_no = $setting->income_no + 1;
        $setting->save();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم تحويل العملية وانشاء سند قبض جديد " ]);
        $this->emit('postAdded');


    }

    public function savedoctor($price =null)
    {

        
        $supervised=0;
        $doctorexp = $this->operationhold->doctorexp;
        if($price){
          
            $doctorexp = explode(",",$price)[0];
            $supervised = explode(",",$price)[1];
            $this->operationhold->supervised =$supervised;
            $this->operationhold->doctorexp =$doctorexp;
            $this->operationhold->save();
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تحديد اجور الطبيب" ]);
         
        }else{
            $this->operationhold->nsba = $this->nsba;
            $this->operationhold->doctorexp =$this->doctorexp;
            $this->operationhold->save();
        }
        
        if(!$price){
        
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تعديل السعر" ]);
        }else{
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تحديد اجور الطبيب" ]);
        }
  
        $this->emit('operationholdDeleted');

   

 
   }

   public function fillamb()
   {
       $this->ambulance = $this->operationhold->ambulance;
       $this->ambulance_doctor  =   $this->operationhold->ambulance_doctor;
   }
   public function saveAmb()
   {
       $this->operationhold->ambulance =$this->ambulance;
       $this->operationhold->ambulance_doctor = $this->ambulance_doctor;
       $this->operationhold->save();
       $this->emitSelf('postAdded');

       $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تعديل السعر" ]);

   }

   public function savenurse()
   {
       $this->operationhold->nurse_price =$this->nurse_price;
       $this->operationhold->save();
       $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تعديل السعر" ]);

   }

    public function savehelper()
    {
        $this->operationhold->helper =$this->helperprice;
        $this->operationhold->save();

         


        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تعديل السعر" ]);

    }


    public function savehelperm5dr()
    {
        $this->operationhold->helperm5dr =$this->helperm5dr;
        $this->operationhold->save();

        


        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تعديل السعر" ]);

    }

    public function saveqabla()
    {
        $this->operationhold->qabla =$this->qabla;
        $this->operationhold->save();

       


        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم انشاء سند صرف" ]);

    }
    
    public function savem5dr2()
    {
        $this->operationhold->m5dr =$this->m5drprice;
        $this->operationhold->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تحديد اجور المخدر" ]);

    }

    public function savem5dr($price)
    {
       // dd($price);
        $this->operationhold->m5dr_selected =1;

        if($price == 0.07 || $price== 0.06 || $price == 0.05)
{
    $this->operationhold->m5dr = $this->operationhold->operation_price * $price;

}else{

    $this->operationhold->m5dr =$price;
}





        
        $this->operationhold->save();

        //  $data =[
        //     'payment_type' => 1,
        //     'amount_iqd' => $price,
        //     'description' => $this->operationhold->operation_name,
        //     'user_id' => auth()->id(),
        //     'account_type' => 3,
        //     "account_name"=>"مخدر",
        //     "operation_price"=>$this->operationhold->operation_price,
        //     "patinet_id"=>$this->operationhold->patinet_id,
        //     "payment_number"=>$this->operationhold->payment_number

        // ];

        // Payments::create($data);


        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم تحديد اجور المخدر" ]);

    }

    public function fillmqema()
    {
        $this->mqema_price = $this->operationhold->mqema_price;
        $this->mqema_id=  $this->operationhold->mqema_id;
    }

    public function savemqema()
    {
      
        $this->operationhold->mqema_price =$this->mqema_price;
        $this->operationhold->mqema_id =$this->mqema_id;
        $this->operationhold->save();

        $this->emitSelf('postAdded');
        


        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم الحفظ" ]);

    }

    public function delete()
    {
        $this->operationhold->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('OperationHold') ]) ]);
        $this->emit('operationholdDeleted');
    }

    public function render()
    {

        return view('livewire.admin.operationhold.single')
            ->layout('admin::layouts.app');
    }
}
