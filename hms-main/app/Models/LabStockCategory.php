<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabStockCategory extends Model
{
    use HasFactory;

    protected $table = 'lab_stock_categories';

    protected $fillable = [
        'name',
        'code',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getDisplayNameAttribute(): string
    {
        return $this->name . ' (' . $this->code . ')';
    }

    public function getItemsCountAttribute(): int
    {
        return LabStockItem::where('category', $this->name)->count();
    }

    public function getTotalValueAttribute(): float
    {
        return LabStockItem::where('category', $this->name)->sum('total_price');
    }
}
