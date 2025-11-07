<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\WarehouseExport;
use App\Models\Warehouseproduct;
use App\Models\WarehouseExportItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UnitConv;
use App\Models\OperationHold;
class Exp extends Component
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


    public $opid;

    public $opinfo;

    public $queryString = ['opid'];


    public function mount()
    {
        $this->opinfo = OperationHold::find($this->opid);
        $this->date = $this->opinfo->date;
        $this->name = "عمليات : " . $this->opinfo->payment_number;



    }

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
        "total"=>$this->amount * $qty,
       ];

       
       $this->amount = 0;
       $this->qty = 1;
       $this->total = "";
       $this->unit = "";
       $this->qtyInput = 1;
       $this->productID = "";
       $this->item = "";

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
            'menu_no'=>$this->menu_no,
            'opid'=>$this->opid,
        ]);

        $this->opinfo->outexp = $this->totalmenu;
        $this->opinfo->ware_id = $menu->id;
        $this->opinfo->save();

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

        return redirect(route('admin.operationhold.list'));
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

        // dispatch browser event

        $this->dispatchBrowserEvent('refselect');
        
        $this->totalmenu = 0;
        $this->total = $this->qty *  $this->amount;
        foreach ($this->items as $item) {
           $this->totalmenu+= $item['total'];
        }

        return view('livewire.admin.operationhold.exp')
            ->layout('admin::layouts.app', ['title' => "مصاريف العملية"]);
    }
}
