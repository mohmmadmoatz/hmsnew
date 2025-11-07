<?php

namespace App\Http\Livewire\Admin\Warehouse;

use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WarehouseItem;
use App\Models\Warehouseproduct;
use App\Models\UnitConv;


class Update extends Component
{
    use WithFileUploads;

    public $warehouse;

    public $supplier_name;
    public $date;
    public $menu_no;
    public $phone;
    public $address;
    public $image;
    

    public $item;
    public $amount;
    public $qty;
    public $total;
    public $totalmenu;

    public $unit;
    public $productID;

    public $qtyInput;
    public $items = [];
    
    protected $rules = [
        'supplier_name' => 'required',        'date' => 'required',        'menu_no' => 'required',        
    ];

    public function addItem()
    {
        $product=Warehouseproduct::find($this->item);
        $qty =  $this->qtyInput * (UnitConv::where("id",$this->unit)->first()->factor ?? 1);
        $this->items[]=  [
         "name"=>$this->item,
         "productname"=>$product->name,
         "amount"=>$this->amount,
         "qty"=>$qty,
         "unit"=>$this->unit,
         "qtyinput"=>$this->qtyInput,
         "total"=>$this->total
        ];
 
        $this->unit = "";
        $this->qtyInput = 1;
        $this->amount = 0;
        $this->qty = 1;
        $this->total = "";

    }

    public function selectitem()
    {
        $product=Warehouseproduct::find($this->item);
        $this->amount = $product->amount;
        $this->qty = 1;
        $this->qtynow = $product->qtynow;
        $this->total = $product->amount;
        $this->productID = $product->id;
        $this->unit = "";
        $this->qtyInput = 1;
    }

    public function deleteItem($index)
    {
        array_splice($this->items,$index,1);

    }

    public function mount(Warehouse $warehouse){
        $this->warehouse = $warehouse;
        $this->supplier_name = $this->warehouse->supplier_name;
        $this->date = $this->warehouse->date;
        $this->menu_no = $this->warehouse->menu_no;
        $this->phone = $this->warehouse->phone;
        $this->address = $this->warehouse->address;
        $this->image = $this->warehouse->image;   
        $this->items =  WarehouseItem::where("warehouses_id",$this->warehouse->id)->get();
        $this->items  = $this->items->toarray(); 

        for ($i=0; $i < count($this->items); $i++) { 
            $this->items[$i]['productname'] = Warehouseproduct::find($this->items[$i]['product_id'])->name ??"";
        }
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Warehouse') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/warehouse');
        }

        $this->warehouse->update([
            'supplier_name' => $this->supplier_name,
            'date' => $this->date,
            'menu_no' => $this->menu_no,
            'phone' => $this->phone,
            'address' => $this->address,
            'image' => $this->image,
            'user_id' => auth()->id(),
        ]);

        WarehouseItem::where("warehouses_id",$this->warehouse->id)->delete();

        foreach ($this->items as $item) {
          
            $newitem = new WarehouseItem();
            $newitem->name = $item['name'];
            $newitem->product_id = $item['name'];

            $newitem->qty = $item['qty'];
            $newitem->amount = $item['amount'];
            $newitem->total = $item['total'];
            $newitem->warehouses_id = $this->warehouse->id;
            $newitem->save();
        }



    }

    public function render()
    {
        $this->totalmenu = 0;
        $this->total = $this->qtyInput *  $this->amount;
        foreach ($this->items as $item) {
           $this->totalmenu+= $item['total'];
        }

        return view('livewire.admin.warehouse.update', [
            'warehouse' => $this->warehouse
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Warehouse') ])]);
    }
}
