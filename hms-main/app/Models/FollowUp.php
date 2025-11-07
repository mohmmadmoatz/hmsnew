<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
     * Get the pat that owns the FollowUp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pat()
    {
        return $this->belongsTo(Patient::class, 'pat_id');
    }

    /**
     * Get the user that owns the FollowUp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
