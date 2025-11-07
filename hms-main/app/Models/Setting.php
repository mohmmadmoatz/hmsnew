<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the doctor that owns the Setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo("App\Models\User",'doctor_id');
    }
    public function xdoctor()
    {
        return $this->belongsTo("App\Models\User",'xray_doctor_id');
    }

    public function sdoctor()
    {
        return $this->belongsTo("App\Models\User",'doctor_sonar_id');
    }

    public function mdoctor()
    {
        return $this->belongsTo("App\Models\User",'mqema_id');
    }
}
