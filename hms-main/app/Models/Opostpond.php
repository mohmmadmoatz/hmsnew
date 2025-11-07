<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opostpond extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function operationhold()
    {
        return $this->belongsTo(OperationHold::class);
    }

}
