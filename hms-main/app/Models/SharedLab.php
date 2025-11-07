<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SharedLab extends Model
{
    use HasFactory;

    protected $fillable = [
        'share_token',
        'lab_data',
        'patient_data',
        'tests_data',
        'components_data',
        'expires_at',
    ];

    protected $casts = [
        'lab_data' => 'array',
        'patient_data' => 'array',
        'tests_data' => 'array',
        'components_data' => 'array',
        'expires_at' => 'datetime',
    ];

    public static function generateShareToken()
    {
        return Str::random(8);
    }

    public function getShareUrlAttribute()
    {
        return route('shared.lab.show', $this->share_token);
    }
}
