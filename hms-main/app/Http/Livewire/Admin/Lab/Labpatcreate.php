<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Patient;
use App\Models\LabTest;
use App\Models\Room;
use App\Models\MedicineProfile;
use App\Models\Testcomponet;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Redirect;


class Labpatcreate extends Component
{
    use WithFileUploads;

    public $name;
    public $gender = "انثى";
    public $phone;
    public $patientid;
    public $status;
    public $age;
    public $dob;
    public $image;
    public $item;
    public $items = [];
    public $amount;
    public $totalamount=0;
    public $components = [];    
    public $testID;
    public $selected=false;
    //public $selectall;

    public $patient_id;
    protected $queryString = [];

    public $patinfo;

    public $inter_at;

    public $qty;

    public $total;
    
    protected $rules = [
        'name' => 'required',
       // 'dob' => 'nullable|date|before:today',
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function mount()
    {
        $this->inter_at = date("Y-m-d");
        
                
    }

    public function clear()
    {
        $this->patinfo = "";
        $this->patient_id = "";
        $this->selected = false;
        $this->name ="";
        $this->age = "";
        $this->dob = "";
        $this->gender = "";
        $this->phone = "";
    }

    public function selectpat($id)
    {
        $this->patient_id = $id;
        $this->patinfo = Patient::find($id);
        $this->selected = true;
        $this->name = $this->patinfo->name;
        $this->dob = $this->patinfo->dob;
        $this->calculateAge();
        $this->gender = $this->patinfo->gender;
        $this->phone = $this->patinfo->phone;
    }

    public function selectitem()
    {
        if($this->item){
            $item=LabTest::find($this->item);
            $this->amount = $item->amount;
            $this->testID = $this->item;
          //  $this->selectall();
        }
       
    }


    public function selectall()
    {   
            $this->components = Testcomponet::where('test_id',$this->testID)->pluck("id");
            // change int to string
            $this->components = $this->components->toArray();
            $this->components = array_map('strval', $this->components);
            
            $this->calculateTestAmount();

    }

    public function updatedComponents()
    {
        $this->calculateTestAmount();
    }

    public function updatedDob()
    {
        $this->calculateAge();
    }

    public function calculateAge()
    {
        if ($this->dob) {
            $this->age = \Carbon\Carbon::parse($this->dob)->age;
        } else {
            $this->age = null;
        }
    }

    public function calculateTestAmount()
    {

        
        
        $amount =0;

        foreach ($this->components as $item => $value) {
           $price = Testcomponet::find($value)->price;
           $amount += $price;
        }

        if($amount > 0){
            $this->amount = $amount;
        }else{
            $this->amount = $item=LabTest::find($this->testID)->amount;
        }


    }

    public function deleteitem($index)
    {
        array_splice($this->items,$index,1);

    }

    public function addItem()
    {
        $product=LabTest::find($this->item);

        
        if(count($this->components)){
            $selectedcomponents =  $this->components;
        }else{
            $selectedcomponents =  Testcomponet::where("test_id",$this->testID)->pluck("id")->toArray();
        }

        

        $this->items[]=  [
         "id"=>$this->item,
         "name"=>$product->name,
         "amount"=>$this->amount,
         "selectedcomponents"=>$selectedcomponents,
         "category_id"=>$product->category_id,
        ];

        

       

        $this->amount = 0;
        $this->qty = 1;
        $this->total = "";
        $this->item = "";
        $this->testID="";
        $this->components = [];

    }

    public function create()
    {

        if(count($this->items) ==0){

            if($this->testID){
                $this->addItem();
                
                $total=0;
        foreach ($this->items as $item) {
           $total = $total + $item['amount'];
        }
        $this->totalamount = $total;

            }
            
        }

        if(!$this->patient_id)
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Patient') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/patients','public');
        }
        
        if($this->patient_id){
           
            Redirect::create([
                "pat_id"=>$this->patinfo->id,
                "redirect_id"=>$this->status,
                "total_lab"=>$this->totalamount,
                "lab"=>json_encode($this->items),
                'is_second'=>auth()->user()->is_second
            ]);

           
          

        }else{
            $pat = Patient::create([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'status' => $this->status,
                'image' => $this->image,
                'dob' => $this->dob,
                'age' => $this->age,
                'lab'=>json_encode($this->items),
                "total_lab"=>$this->totalamount

            ]);

            Redirect::create([
                "pat_id"=>$pat->id,
                "redirect_id"=>$this->status,
                "total_lab"=>$this->totalamount,
                "lab"=>json_encode($this->items),
                'is_second'=>auth()->user()->is_second
            ]);

        }

        

       


        $this->reset();

        
        $this->inter_at = date("Y-m-d");


    }

    public function render()
    {
       $total=0;
        foreach ($this->items as $item) {
           $total = $total + $item['amount'];
        }
        $this->totalamount = $total;
        return view('livewire.admin.lab.patcreate')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Patient') ])]);
    }
}
