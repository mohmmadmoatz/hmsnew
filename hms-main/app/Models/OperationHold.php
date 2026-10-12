<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationHold extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $withs = ["ambdoctor"];

    protected $casts = [
        'anesthesia_doctors' => 'array',
    ];

    // اسماء اطباء التخدير مفصولة بفارزة للعرض
    public function getAnesthesiaNamesAttribute()
    {
        return implode(" ، ", $this->anesthesia_doctors ?? []);
    }

    public function Patient()
    {
        return $this->belongsTo("App\Models\Patient",'patinet_id');
    }

    public function room()
    {
        return $this->Patient->room ??"";
    }
    
    public function doctor()
    {
        return $this->belongsTo("App\Models\User",'doctor_id');
    }

    public function ambdoctor()
    {
        return $this->belongsTo("App\Models\User",'ambulance_doctor');
    }

    public function mqema()
    {
        return $this->belongsTo("App\Models\User",'mqema_id');
    }

    public function getHaspostpondAttribute()
    {
        $data = Opostpond::where('operationhold_id',$this->id)->where('status','pending')->first();
        
        if($data)
        {
            return $data;
        }
        return false;

    }

    

    /**
     * Get the payment that owns the OperationHold
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   

}
