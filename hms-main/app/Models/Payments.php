<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory,SoftDeletes;
    public $guarded = [];
    public $with = ['user','stagename','Patient'];

    /**
     * Get the user that owns the Payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }


    /**
     * Get the stagename that owns the Payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stagename()
    {
        return $this->belongsTo(Stage::class, 'redirect');
    }


    public function doctor()
    {
        return $this->belongsTo("App\Models\User",'doctor_id');
    }


    /**
     * Get the Patient that owns the Payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Patient()
    {
        return $this->belongsTo("App\Models\Patient",'patinet_id');
    }

    public function rid()
    {
        return $this->belongsTo("App\Models\Redirect",'rid');
    }

    


    // public function setWaslNumberAttribute()
    // {
    //     // $lastNumber = Payments::where("payment_type",$this->payment_type)->count("wasl_number") + 1;

    //     // $this->attributes['wasl_number'] = $lastNumber;
    // }
}
