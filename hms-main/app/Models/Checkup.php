<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;
    protected $guarded = [];  


    public function doctor()
    {
        return $this->belongsTo("App\Models\User", 'doctor_id');
    }


    public function patient()
    {
        return $this->belongsTo("App\Models\Patient", 'patient_id');
    }
}
