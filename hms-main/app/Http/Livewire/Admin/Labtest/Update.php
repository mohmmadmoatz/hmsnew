<?php

namespace App\Http\Livewire\Admin\Labtest;

use App\Models\LabTest;
use App\Models\Testcomponet;

use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $labtest;

    public $name;
    public $amount;
    public $category_id;

    public $compontes = [];

    
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(LabTest $labtest){
        $this->labtest = $labtest;
        $this->name = $this->labtest->name;
        $this->amount = $this->labtest->amount;
        $this->category_id = $this->labtest->category_id;
        
        $compontes =  Testcomponet::where("test_id",$this->labtest->id)->get();
        $this->compontes = $compontes->toArray();

        for ($i=0; $i < count($this->compontes); $i++) { 
                $this->compontes[$i]['options'] = json_decode($this->compontes[$i]['options']);
        }

       
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function deleteItem($index)
    {
        $new = Testcomponet::find($this->compontes[$index]['id'] ?? 0);
        
        if($new){
            $new->delete();
        }
        array_splice($this->compontes,$index,1);
       
        
    }

    public function deleteopt($index,$parent)
    {

        array_splice($this->compontes[$parent]['options'],$index,1);



    }

    public function addComponet()
    {
        $this->compontes[] = [
            "name"=>"",
            "result_type"=>"value",
            "options"=>[],
            "unit"=>"",
            "normal_range"=>"",
            "price"=>"",
        ];
    }

    public function changekey($key,$value,$index)
    {
        $this->compontes[$index][$key] = $value;
    }

    public function addopt($index)
    {
        $this->compontes[$index]['options'][] = "";
    }

    public function changesub($value,$index,$parent)
    {
        $this->compontes[$parent]['options'][$index] = $value;
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('LabTest') ]) ]);
        
        $this->labtest->update([
            'name' => $this->name,    
            'amount' => $this->amount,      
            'category_id'=>$this->category_id            


        ]);

      //  dd($this->compontes);

       // Testcomponet::where("test_id",$this->labtest->id)->delete();

        

        foreach ($this->compontes as $item) {
            $new = Testcomponet::find($item['id'] ?? 0);
            if(!$new)
            $new = new Testcomponet();
            $new->test_id = $this->labtest->id;
            $new->name = $item['name'];
            $new->result_type = $item['result_type'];
            $new->options = json_encode($item['options']);
            $new->unit = $item['unit'];
            $new->normal_range = $item['normal_range'];
            $new->price = $item['price'];
            $new->save();
            }
          
    }

    public function render()
    {
        return view('livewire.admin.labtest.update', [
            'labtest' => $this->labtest
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('LabTest') ])]);
    }
}
