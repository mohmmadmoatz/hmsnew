<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empadvance extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='emp_advance';
    public function emp()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
