<?php

namespace App\Http\Livewire\Admin\Warehouse;

use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\Warehouseproduct;
use App\Models\UnitConv;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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
    public $productID;
    public $unit;
    public $qtyInput;
    public $items = [];
    
    protected $rules = [
        'supplier_name' => 'required',        'date' => 'required',        'menu_no' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
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

    public function deleteItem($index)
    {
        array_splice($this->items,$index,1);

    }

    public function create()
    {

        if(count($this->items) ==0){

            if($this->productID){
                $this->addItem();
               
                $this->totalmenu = 0;
                $this->total = $this->qty *  $this->amount;
                foreach ($this->items as $item) {
                   $this->totalmenu+= $item['total'];
                }
               
        }
    }

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Warehouse') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/warehouse','public');
        }

       $menu =  Warehouse::create([
            'supplier_name' => $this->supplier_name,
            'date' => $this->date,
            'menu_no' => $this->menu_no,
            'phone' => $this->phone,
            'address' => $this->address,
            'image' => $this->image,
            'total' => $this->totalmenu,
            'user_id' => auth()->id(),
        ]);
     
        foreach ($this->items as $item) {
          
            $newitem = new WarehouseItem();
            $newitem->name = $item['name'];
            $newitem->product_id = $item['name'];
            $newitem->qty = $item['qty'];

            $newitem->qtyinput = $item['qtyinput'];
            $newitem->unit = $item['unit'];

            $newitem->amount = $item['amount'];
            $newitem->total = $item['total'];
            $newitem->warehouses_id = $menu->id;
            $newitem->save();
        }

        $this->reset();
    }

    public function render()
    {
        $this->totalmenu = 0;
        $this->total = $this->qtyInput *  $this->amount;
        foreach ($this->items as $item) {
           $this->totalmenu+= $item['total'];
        }
        return view('livewire.admin.warehouse.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Warehouse') ])]);
    }
}
