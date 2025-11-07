<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabStockMovement extends Model
{
    use HasFactory;

    protected $table = 'lab_stock_movements';

    protected $fillable = [
        'stock_item_id',
        'movement_type',
        'quantity',
        'previous_quantity',
        'current_quantity',
        'reference_number',
        'reason',
        'notes',
        'performed_by',
        'movement_date',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'quantity' => 'integer',
        'previous_quantity' => 'integer',
        'current_quantity' => 'integer',
    ];

    // Relationships
    public function stockItem(): BelongsTo
    {
        return $this->belongsTo(LabStockItem::class, 'stock_item_id');
    }

    // Scopes
    public function scopeInMovements($query)
    {
        return $query->where('movement_type', 'in');
    }

    public function scopeOutMovements($query)
    {
        return $query->where('movement_type', 'out');
    }

    public function scopeAdjustments($query)
    {
        return $query->where('movement_type', 'adjustment');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('movement_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getMovementTypeLabelAttribute(): string
    {
        return match($this->movement_type) {
            'in' => 'وارد',
            'out' => 'صادر',
            'adjustment' => 'تعديل',
            'transfer' => 'تحويل',
            'return' => 'إرجاع',
            'waste' => 'هدر',
            default => $this->movement_type,
        };
    }

    public function getIsIncreaseAttribute(): bool
    {
        return in_array($this->movement_type, ['in', 'return']);
    }

    public function getIsDecreaseAttribute(): bool
    {
        return in_array($this->movement_type, ['out', 'waste']);
    }
}
