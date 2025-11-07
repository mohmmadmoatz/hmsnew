<?php

namespace App\Http\Livewire\Admin\Warehouseitem;

use App\Models\Warehouseproduct;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UnitConv;

class Update extends Component
{
    use WithFileUploads;

    public $warehouseitem;

    public $name;
    public $amount;
    public $unit_id;
    public $baseunit;
    public $unitfactor;
    public $expire;
    public $cat;
    
    //protected $queryString = ['baseunit','unit_id'];

    protected $rules = [
        'name' => 'required',        
    ];
    
    public function addUnit()
    {
        $item = new UnitConv();
        $item->base_unit_id = $this->baseunit;
        $item->factor = $this->unitfactor;
        $item->unit_id = $this->unit_id;
        $item->product_id = $this->warehouseitem->id;
        $item->save();

        $this->warehouseitem->update([
            "baseunit"=>$this->baseunit,            
        ]);

        
    }

    public function deleteUnitConv($id)
    {
        
        $item = UnitConv::find($id);
        $item->delete();
    }


    public function mount(Warehouseproduct $warehouseitem){
        $this->warehouseitem = $warehouseitem;
        $this->name = $this->warehouseitem->name;
        $this->amount = $this->warehouseitem->amount;   
        $this->baseunit = $this->warehouseitem->baseunit;   
        $this->expire = $this->warehouseitem->expire;
        $this->cat = $this->warehouseitem->cat_id;

    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('WarehouseItem') ]) ]);
        
        $this->warehouseitem->update([
            'name' => $this->name,
            'amount' => $this->amount,
            "baseunit"=>$this->baseunit,
            "expire" => $this->expire,
            "cat_id" => $this->cat,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.warehouseitem.update', [
            'warehouseitem' => $this->warehouseitem
        ])->layout('admin::layouts.app', ['title' => "تعديل مادة" ]);
    }
}
