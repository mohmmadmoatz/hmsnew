<?php

namespace App\Http\Livewire\Admin\Stage;

use App\Models\Stage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $stage;

    public $name;
    public $doctor_id;
    public $total_price;
    public $doctor_price;
    public $other_price;
    public $res_price;
    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Stage $stage){
        $this->stage = $stage;
        $this->name = $this->stage->name;
        $this->doctor_id = $this->stage->doctor_id;
        $this->total_price = $this->stage->total_price;
        $this->doctor_price = $this->stage->doctor_price;        
        $this->other_price = $this->stage->other_price;        
        $this->res_price = $this->stage->res_price;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Stage') ]) ]);
        
        $this->stage->update([
            'name' => $this->name,
            'doctor_id' => $this->doctor_id,            'total_price' => $this->total_price,            'doctor_price' => $this->doctor_price, 
            'other_price' => $this->other_price,            
            'res_price' => $this->res_price,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stage.update', [
            'stage' => $this->stage
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Stage') ])]);
    }
}
