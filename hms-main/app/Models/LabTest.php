<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get the category that owns the LabTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(LabCategory::class, 'category_id');
    }

    public function components()
    {
        return $this->hasMany(PatTestComponet::class, 'test_id');
    }
    public function tests()
    {
        return $this->hasMany(PatTests::class, 'test_id');
    }   

   
    

}
