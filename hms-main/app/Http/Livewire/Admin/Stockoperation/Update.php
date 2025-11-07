<?php

namespace App\Http\Livewire\Admin\Stockoperation;

use App\Models\Stockoperation;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $stockoperation;

    public $op_type;
    public $product_id;
    public $to_person;
    public $to_department;
    public $price;
    public $notes;
    public $image;
    public $qty;
    
    protected $rules = [
        'op_type' => 'required',        'product_id' => 'required',        'qty' => 'required',        
    ];

    public function mount(Stockoperation $stockoperation){
        $this->stockoperation = $stockoperation;
        $this->op_type = $this->stockoperation->op_type;
        $this->product_id = $this->stockoperation->product_id;
        $this->to_person = $this->stockoperation->to_person;
        $this->to_department = $this->stockoperation->to_department;
        $this->price = $this->stockoperation->price;
        $this->notes = $this->stockoperation->notes;
        $this->image = $this->stockoperation->image;
        $this->qty = $this->stockoperation->qty;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Stockoperation') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        $this->stockoperation->update([
            'op_type' => $this->op_type,            'product_id' => $this->product_id,            'to_person' => $this->to_person,            'to_department' => $this->to_department,            'price' => $this->price,            'notes' => $this->notes,
            'image' => $this->image,
            'qty' => $this->qty,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stockoperation.update', [
            'stockoperation' => $this->stockoperation
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Stockoperation') ])]);
    }
}
