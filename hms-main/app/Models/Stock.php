<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = [];  
    use HasFactory;
    
    protected $appends=["qtynow"];

    public function getQtynowAttribute()
    {
        $sumImports = Stockoperation::where("op_type",'Import')->sum("qty");
        $sumExport = Stockoperation::where("op_type",'Export')->sum("qty");
        return ($this->qty + $sumImports) - $sumExport;
    }


}
