<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use App\Models\Payments;
use App\Models\Patient;
use App\Models\Testcomponet;
use App\Models\PatTests;
use App\Models\PatTestComponet;
use App\Models\Redirect;


use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $patient_id;
    public $notes;
    public $image;
    public $payment_id;
    protected $queryString = ['patient_id','payment_id','rid'];
    public $tests = [];
    public $indexID = 0;
    public $rid;
    public $reference;
 

    protected $rules = [
        'patient_id' => 'required',        
      //  'reference' => 'required',
    ];

    public function mount()
    {
        $pat = Patient::find($this->patient_id);
        $rid = Redirect::find($this->rid);
        if($pat){

       
        $this->tests = json_decode($rid->lab,true);
        
        if(count($this->tests)){
           
            $this->indexID = 0;
            
            for ($i=0; $i < count($this->tests); $i++) { 
                $this->tests[$i]["items"] = Testcomponet::whereIn("id",$this->tests[$i]['selectedcomponents'])->get()->toArray();
            }

            // fill result field in each item

            for ($i=0; $i < count($this->tests); $i++) { 
                for ($j=0; $j < count($this->tests[$i]["items"]); $j++) { 
                    $this->tests[$i]["items"][$j]["result"] = "";
                }
            }
          
            
        }

           // dd($this->tests);
            
            
        }
        
    }

   public function updatekey($parent,$index,$value)
   {
    $this->tests[$parent]['items'][$index]['result'] = $value;
    
   // dd($this->tests[$parent]['items'][$index]['result']);

   }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create($print=false)
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Lab') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/labs','public');
        }

       

        $labdata = Lab::create([
            'patient_id' => $this->patient_id,
            'notes' => $this->notes,
            'image' => $this->image,
            'reference' => $this->reference,
            'is_second' => auth()->user()->is_second,          
        ]);

        foreach ($this->tests as $item) {

           $newtest =  new PatTests();
           $newtest->lab_id = $labdata->id;
           $newtest->category_id = $item['category_id'];
           $newtest->test_id = $item['id'];
           $newtest->amount = $item['amount'];
           $newtest->save();

           foreach ($item['items'] as $sub) {
               
               $newsub = new PatTestComponet();
               $newsub->pat_test_id = $newtest->id;
               $newsub->componet_id = $sub['id'];
               $newsub->test_id = $sub['test_id'];
               $newsub->result = $sub['result'] ?? 0;
               $newsub->save();
           }
           

        }
       

        $pat = Payments::find($this->payment_id);
        $pat->redirect_done = $labdata->id;
        $pat->save();


        if($print == true)
        $this->dispatchBrowserEvent('open-window', ['url' => route("labprint") . "?id=$labdata->id"]);
        


        $this->reset();
    }

    public function render()
    {
        
        return view('livewire.admin.lab.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Lab') ])]);
    }
}
