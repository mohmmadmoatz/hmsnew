<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouseproduct extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $appends=["qtynow",'incomeqty','exportqty'];
    

    public function base()
    {
        return $this->belongsTo(Unit::class, 'baseunit');
    }

    public function getIncomeqtyAttribute()
    {
        $income = WarehouseItem::where("product_id",$this->id)->sum("qty");
        return $income;
    }

    public function getExportqtyAttribute()
    {
        $export = WarehouseExportItem::where("product_id",$this->id)
        
        // where wharehouseexport opid is null

        ->whereHas("export",function($q){
            $q->whereNull("opid");
        })

        ->sum("qty");
        
        return $export;
    }

    public function getQtynowAttribute()
    {
      
        return $this->incomeqty - $this->exportqty;
    }

    // get price
    public function getPriceAttribute()
    {
        $income = WarehouseItem::where("product_id",$this->id)->sum("total");
        return $income;
    }

    function getSinglePriceAttribute() {
        if($this->incomeqty == 0)
            return 0;
        $single = $this->price / $this->incomeqty;
        return $single;
    }

    function getPriceNowAttribute() {
        
        $totalOut = $this->exportqty * $this->single_price;
        $net = $this->price - $totalOut;
        return round($net,2);
    }

    // belongs to category
    public function cat()
    {
        return $this->belongsTo(Stockcat::class, 'cat_id');
    }



}
