<?php

namespace App\Http\Livewire\Admin\Labtest;

use App\Models\LabTest;
use App\Models\Testcomponet;
use Livewire\Component;

use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $compontes = [];
    public $amount;
    public $category_id;
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function addComponet()
    {
        $this->compontes[] = [
            "name"=>"",
            "result_type"=>"value",
            "options"=>[],
            "unit"=>"",
            "normal_range"=>"",
            "price"=>0
        ];
    }

    public function deleteItem($index)
    {
        array_splice($this->compontes,$index,1);

    }

    public function deleteopt($index,$parent)
    {
        array_splice($this->compontes[$parent]['options'],$index,1);

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

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('LabTest') ])]);
        
       

       $testid =  LabTest::create([
            'name' => $this->name,            
            'amount' => $this->amount,
            'category_id'=>$this->category_id            
        ]);

        foreach ($this->compontes as $item) {
          $new = new Testcomponet();
          $new->test_id = $testid->id;
          $new->name = $item['name'];
          $new->result_type = $item['result_type'];
          $new->options = json_encode($item['options']);
          $new->unit = $item['unit'];
          $new->normal_range = $item['normal_range'];
          $new->price = $item['price'];
          $new->save();
        }

         $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.labtest.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('LabTest') ])]);
    }
}
