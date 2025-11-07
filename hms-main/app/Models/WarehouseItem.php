<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    use HasFactory;
    protected $guarded =[];
   
    /**
     * Get the export that owns the WarehouseItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   
   

}
