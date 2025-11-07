<?php

namespace App\Http\Livewire\Admin\Stockoperation;

use App\Models\Stockoperation;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Stockoperation') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        Stockoperation::create([
            'op_type' => $this->op_type,            'product_id' => $this->product_id,            'to_person' => $this->to_person,            'to_department' => $this->to_department,            'price' => $this->price,            'notes' => $this->notes,
            'qty' => $this->qty,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.stockoperation.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Stockoperation') ])]);
    }
}
