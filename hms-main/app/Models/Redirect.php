<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;
    protected $table = "redirects";
    protected $guarded=[];

    public function Patient()
    {
        return $this->belongsTo("App\Models\Patient",'pat_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'redirect_id');
    }

    public function doctor()
    {
        return $this->belongsTo("App\Models\User",'redirect_doctor_id');
    }

}
