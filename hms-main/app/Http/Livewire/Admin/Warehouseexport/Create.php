<?php

namespace App\Http\Livewire\Admin\Warehouseexport;

use App\Models\WarehouseExport;
use App\Models\Warehouseproduct;
use App\Models\WarehouseExportItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UnitConv;
class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $date;
    public $total;
    public $items=[];

    public $item;
    public $amount;
    public $qty;
    public $qtynow;
    public $totalmenu;

    public $menu_no;

    public $unit;
    public $qtyInput;
    public $productID;
    protected $rules = [
        'name' => 'required',        'date' => 'required',        
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

       
       $this->amount = 0;
       $this->qty = 1;
       $this->total = "";
       $this->unit = "";
       $this->qtyInput = 1;
       $this->productID = "";

    }

    public function deleteItem($index)
    {
        array_splice($this->items,$index,1);
    }

    public function updated($input)
    {
        $this->validateOnly($input);
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

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('WarehouseExport') ])]);
        
       $menu = WarehouseExport::create([
            'name' => $this->name,
            'date' => $this->date,
            'total' => $this->totalmenu,
            'user_id' => auth()->id(),
            'menu_no'=>$this->menu_no
        ]);

        foreach ($this->items as $item) {
          
            $newitem = new WarehouseExportItem();
            $newitem->product_id = $item['name'];
            $newitem->qty = $item['qty'];
        
            $newitem->qtyinput = $item['qtyinput'];
            $newitem->unit = $item['unit'];

            $newitem->amount = $item['amount'];
            $newitem->total = $item['total'];
            $newitem->export_id = $menu->id;
            $newitem->save();
        }

        $this->reset();
    }

    public function selectitem()
    {
        $product=Warehouseproduct::find($this->item);
        $this->amount = $product->amount;
        $this->qty = 1;
        $this->qtynow = $product->qtynow;
        $this->total = $product->amount;
        $this->productID = $product->id;
        $this->qtyInput =1;
    }

    public function render()
    {
        
        $this->totalmenu = 0;
        $this->total = $this->qty *  $this->amount;
        foreach ($this->items as $item) {
           $this->totalmenu+= $item['total'];
        }

        return view('livewire.admin.warehouseexport.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('WarehouseExport') ])]);
    }
}
