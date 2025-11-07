<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use App\Models\PatTests;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Patient;
use App\Models\PatTestComponet;
class Update extends Component
{
    use WithFileUploads;

    public $lab;

    public $patient_id;
    public $notes;
    public $image;
    public $payment_id;
    protected $queryString = ['patient_id','payment_id','rid'];
    public $tests = [];
    public $indexID = 0;
    public $rid;
    
    protected $rules = [
        'patient_id' => 'required',        
    ];

    public function mount(Lab $lab){
        $this->lab = $lab;
        $this->patient_id = $this->lab->patient_id;
        $this->notes = $this->lab->notes;
        $this->image = $this->lab->image;    
        
        $pat = Patient::find($this->patient_id);
        $rid = PatTests::where("lab_id", $this->lab->id)->get();
        if($pat){

       
        $this->tests = $rid;
        
   

           // dd($this->tests);
            
            
        }
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function updatekey($id,$value)
    {
    
        $data = PatTestComponet::find($id);
        $data->result = $value;
        $data->save();
 
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Lab') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/labs','public');
        }

        $this->lab->update([
            'patient_id' => $this->patient_id,
            'notes' => $this->notes,
            'image' => $this->image,            
        ]);
        $id = $this->lab->id;

        $this->dispatchBrowserEvent('open-window', ['url' => route("labprint") . "?id=$id"]);

    }

    public function render()
    {
        return view('livewire.admin.lab.update', [
            'lab' => $this->lab
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Lab') ])]);
    }
}
