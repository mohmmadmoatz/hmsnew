<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saveaccount extends Model
{
    use HasFactory;
    protected $table = "saveaccount";
    protected $guarded=[];
    /**
     * Get the user that owns the Saveaccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
