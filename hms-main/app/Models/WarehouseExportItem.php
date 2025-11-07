<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseExportItem extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function export()
    {
        return $this->belongsTo(WarehouseExport::class, 'export_id', 'id');
    }
    
}
