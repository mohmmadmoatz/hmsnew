<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockoperation extends Model
{
    use HasFactory;
    protected $guarded = [];  
    public function stock()
    {
        return $this->belongsTo("App\Models\Stock", 'product_id');
    }

}
