<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitConv extends Model
{
    use HasFactory;
    protected $table = 'units_conv';

    /**
     * Get the unit that owns the UnitConv
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function base()
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    
}
