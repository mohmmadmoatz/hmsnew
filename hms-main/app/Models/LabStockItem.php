<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class LabStockItem extends Model
{
    use HasFactory;

    protected $table = 'lab_stock_items';

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'quantity',
        'min_quantity',
        'unit_price',
        'total_price',
        'supplier',
        'purchase_date',
        'expiry_date',
        'batch_number',
        'location',
        'status',
        'expiry_notification_sent',
        'days_before_expiry_notification',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'expiry_notification_sent' => 'boolean',
        'quantity' => 'integer',
        'min_quantity' => 'integer',
        'days_before_expiry_notification' => 'integer',
    ];

    // Relationships
    public function movements(): HasMany
    {
        return $this->hasMany(LabStockMovement::class, 'stock_item_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function expiryNotifications(): HasMany
    {
        return $this->hasMany(LabStockExpiryNotification::class, 'stock_item_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeLowStock($query)
    {
        return $query->where('status', 'low_stock');
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', Carbon::now()->addDays($days))
                    ->where('expiry_date', '>=', Carbon::now());
    }

    // Accessors & Mutators
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date < Carbon::now();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        $notificationDays = $this->days_before_expiry_notification ?? 30;
        return $this->expiry_date <= Carbon::now()->addDays($notificationDays) && !$this->is_expired;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    public function getDaysUntilExpiryAttribute(): int
    {
        return Carbon::now()->diffInDays($this->expiry_date, false);
    }

    public function getTotalValueAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    // Methods
    public function updateStatus(): void
    {
        $newStatus = 'active';

        if ($this->is_expired) {
            $newStatus = 'expired';
        } elseif ($this->is_low_stock) {
            $newStatus = 'low_stock';
        } elseif ($this->quantity <= 0) {
            $newStatus = 'out_of_stock';
        }

        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }

    public function addMovement(string $type, int $quantity, string $reason = null, string $notes = null): LabStockMovement
    {
        $previousQuantity = $this->quantity;

        // Calculate new quantity based on movement type
        switch ($type) {
            case 'in':
                $this->quantity += $quantity;
                break;
            case 'out':
            case 'waste':
                $this->quantity -= $quantity;
                break;
            case 'adjustment':
                $this->quantity = $quantity;
                break;
        }

        $this->total_price = $this->quantity * $this->unit_price;
        $this->save();

        // Update status
        $this->updateStatus();

        // Create movement record
        return $this->movements()->create([
            'movement_type' => $type,
            'quantity' => $quantity,
            'previous_quantity' => $previousQuantity,
            'current_quantity' => $this->quantity,
            'reason' => $reason,
            'notes' => $notes,
            'performed_by' => auth()->user()->name ?? 'System',
            'movement_date' => now(),
            'unit_cost' => $this->unit_price,
            'total_cost' => $quantity * $this->unit_price,
        ]);
    }

    public function checkAndSendExpiryNotification(): void
    {
        if ($this->expiry_notification_sent) {
            return;
        }

        $daysUntilExpiry = $this->days_until_expiry;
        $notificationDays = $this->days_before_expiry_notification;

        if ($daysUntilExpiry <= $notificationDays && $daysUntilExpiry >= 0) {
            // Send notification
            $this->expiryNotifications()->create([
                'notification_type' => $daysUntilExpiry <= 7 ? 'critical_expiry' : 'expiring_soon',
                'days_until_expiry' => $daysUntilExpiry,
                'expiry_date' => $this->expiry_date,
                'message' => "المنتج '{$this->name}' سينتهي في {$daysUntilExpiry} يوم",
                'notified_user_id' => $this->created_by,
            ]);

            $this->update(['expiry_notification_sent' => true]);
        }
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            // Auto-calculate total price
            if ($item->quantity && $item->unit_price) {
                $item->total_price = $item->quantity * $item->unit_price;
            }
        });

        static::saved(function ($item) {
            // Update status after saving
            $item->updateStatus();
        });
    }
}
