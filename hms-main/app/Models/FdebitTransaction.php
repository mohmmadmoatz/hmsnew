<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdebitTransaction extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get the category that owns the FdebitTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FdebitCategory::class, 'category_id');
    }

}
