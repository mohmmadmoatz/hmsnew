<?php

namespace App\Http\Livewire\Admin\Warehouseexport;

use App\Models\WarehouseExport;
use App\Models\Warehouseproduct;
use App\Models\WarehouseExportItem;
use Livewire\Component;
use App\Models\UnitConv;
use Livewire\WithFileUploads;
use App\Models\OperationHold;
class Update extends Component
{
    use WithFileUploads;

    public $warehouseexport;

    public $name;
    public $date;
    public $total;
    public $items=[];

    public $item;
    public $amount;
    public $qty;
    public $totalmenu;
    public $menu_no;
    public $productID;
    public $unit;
    public $qtyInput;
    public $expout;
    


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

    public function mount(WarehouseExport $warehouseexport){
        $this->warehouseexport = $warehouseexport;
        $this->name = $this->warehouseexport->name;
        $this->date = $this->warehouseexport->date;
        $this->totalmenu = $this->warehouseexport->totalmenu;   
        
        
        $this->menu_no = $this->warehouseexport->menu_no;   
        $this->items =  WarehouseExportItem::where("export_id",$this->warehouseexport->id)->get();
        
        $this->items  = $this->items->toarray();   
        
        for ($i=0; $i < count($this->items); $i++) { 
            $this->items[$i]['productname'] = Warehouseproduct::find($this->items[$i]['product_id'])->name;
            $this->items[$i]['name'] =$this->items[$i]['product_id'];
        }

        for ($i=0; $i < count($this->items); $i++) { 
            $unit = UnitConv::where("id",$this->items[$i]['unit'])->first();
            
            $this->items[$i]['unitname'] = $unit->unit->name ??"قطعة";
        }


    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('WarehouseExport') ]) ]);
        
        $this->warehouseexport->update([
            'name' => $this->name,
            'date' => $this->date,
            'total' => $this->totalmenu,
            'user_id' => auth()->id(),
            'menu_no'=>$this->menu_no
        ]);

        $op = OperationHold::find($this->warehouseexport->opid);

        if($op){
            $op->outexp = $this->expout;
            $op->save();
        }

        WarehouseExportItem::where("export_id",$this->warehouseexport->id)->delete();

        foreach ($this->items as $item) {
          
            $newitem = new WarehouseExportItem();
            $newitem->product_id = $item['name'];
            $newitem->qty = $item['qty'];
        
            $newitem->qtyinput = $item['qtyinput'];
            $newitem->unit = $item['unit'];

            $newitem->amount = $item['amount'];
            $newitem->total = $item['total'];
            $newitem->export_id = $this->warehouseexport->id;
            $newitem->save();
        }

    }
    public function deleteItem($index)
    {
        array_splice($this->items,$index,1);

    }
    public function selectitem()
    {
    

        $product=Warehouseproduct::find($this->item);
        $this->amount = $product->single_price;
        $this->qty = 1;
        $this->qtynow = $product->qtynow;
        $this->total = $product->single_price;
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
     

        return view('livewire.admin.warehouseexport.update', [
            'warehouseexport' => $this->warehouseexport
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('WarehouseExport') ])]);
    }
}
