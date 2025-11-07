<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded=[];

   // employee has many Empadvance with sum of advance amount
   


    public function empadvance()
    {
         return $this->hasMany(Empadvance::class,"emp_id");
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class,"emp_id");
    }

    /**
     * Get the user that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(EmpCategory::class, 'category_id');
    }


}
