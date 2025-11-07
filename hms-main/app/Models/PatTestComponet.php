<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatTestComponet extends Model
{
    use HasFactory;
    protected $guarded=[];
    /**
     * Get the componet that owns the PatTestComponet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function componet()
    {
        return $this->belongsTo(Testcomponet::class, 'componet_id');
    }
    public function patTest()
    {
        return $this->belongsTo(PatTests::class, 'pat_test_id');
    }
}
