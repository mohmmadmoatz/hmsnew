<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function patient()
     {
         return $this->belongsTo("App\Models\Patient", 'patient_id');
     }

    public function patTests()
    {
        return $this->hasMany("App\Models\PatTests", 'lab_id');
    }

    public function allComponents()
    {
        return $this->hasManyThrough("App\Models\PatTestComponet", "App\Models\PatTests", 'lab_id', 'pat_test_id');
    }
}
