<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Patient;
use App\Models\LabSetting;
use App\Models\Room;
use App\Models\MedicineProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Redirect;
use App\Models\LabTest;
use App\Models\Testcomponet;


class Labpatedit extends Component
{
    use WithFileUploads;
    public $patient;
    public $name;
    public $gender = "انثى";
    public $phone;
    public $patientid;
    public $status;
    public $age;
    public $image;

    public $item;
    public $items = [];
    public $components = [];    

    public $amount;
    public $totalamount=0;
    public $testID;
    public $redirect;
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function mount(Redirect $redirect){
        $this->redirect = $redirect;
     
        $this->name = $this->redirect->Patient->name;
        $this->age = $this->redirect->Patient->age;
        $this->phone = $this->redirect->Patient->phone;
        $this->gender = $this->redirect->Patient->gender;
        $this->status = $this->redirect->redirect_id;
       
        $items = json_decode($this->redirect->lab);

        foreach ($items as $item) {
            $this->items[]=  [
                "id"=>$item->id,
                "name"=>$item->name,
                "amount"=>$item->amount,
                "selectedcomponents"=>$item->selectedcomponents,
                "category_id"=>$item->category_id,
               ];
        }

    
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

    public function clear()
    {
        $this->patinfo = "";
        $this->patient_id = "";
        $this->selected = false;
        $this->name ="";
        $this->age = "";
        $this->gender = "";
        $this->phone = "";
    }
   
    public function selectall()
    {   
            $this->components = Testcomponet::where('test_id',$this->testID)->pluck("id");
            // change int to string
            $this->components = $this->components->toArray();
            $this->components = array_map('strval', $this->components);
            
            $this->calculateTestAmount();

    }

    public function deleteitem($index)
    {
        array_splice($this->items,$index,1);

    }

    public function updatedComponents()
    {
        $this->calculateTestAmount();
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

    public function update()
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

        $pat = Patient::find($this->redirect->Patient->id);
        $pat->name = $this->name;
        $pat->gender = $this->gender;
        $pat->phone = $this->phone;
        $pat->lab = json_encode($this->items);
        $pat->total_lab = $this->totalamount;
        $pat->save();

        $this->redirect->update([
            "redirect_id"=>$this->status,
            "total_lab"=>$this->totalamount,
            "lab"=>json_encode($this->items)         
        ]);
        

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Patient') ])]);
        
        

       


   



    }

    public function render()
    {
        $total=0;
        foreach ($this->items as $item) {
           $total = $total + $item['amount'];
        }
        $this->totalamount = $total;
        return view('livewire.admin.lab.editpat')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Patient') ])]);
    }
}
