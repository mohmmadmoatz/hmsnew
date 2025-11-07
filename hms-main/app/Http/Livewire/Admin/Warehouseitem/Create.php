<?php

namespace App\Http\Livewire\Admin\Warehouseitem;

use App\Models\Warehouseproduct;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;


    public $name;
    public $amount;
    public $expire;
    public $cat;
    protected $rules = [
        'name' => 'required',        
    ];

   

    

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('WarehouseItem') ]) ]);
        
        Warehouseproduct::create([
            'name' => $this->name,
            "expire" => $this->expire,
            "cat_id" => $this->cat, 
        ]);

        $this->reset();

    }

    public function render()
    {
        return view('livewire.admin.warehouseitem.create', [

        ])->layout('admin::layouts.app', ['title' => "انشاء مادة" ]);
    }
}
