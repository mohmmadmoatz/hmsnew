<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded=[];


    /**
     * Get the user that owns the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo("App\Models\Employee", 'user_id', 'userid');
    }

    public function getStateAttribute($value)
    {
        switch ($value) {
            case 4:
                return "Card";
                break;
                case 1:
                    return "بصمة";
                    break;
                    case 15:
                        return "بصمة وجه";
                        break;
            default:
                # code...
                break;
        }
        return ucfirst($value);
    }

    public function getTypeAttribute($value)
    {
        switch ($value) {
            case 0:
                return "حظور";
                break;
                case 1:
                    return "انصراف";
                    break;
                  
            default:
                # code...
                break;
        }
        return ucfirst($value);
    }



}
