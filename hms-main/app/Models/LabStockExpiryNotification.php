<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabStockExpiryNotification extends Model
{
    use HasFactory;

    protected $table = 'lab_stock_expiry_notifications';

    protected $fillable = [
        'stock_item_id',
        'notification_type',
        'days_until_expiry',
        'expiry_date',
        'message',
        'is_read',
        'read_at',
        'notified_user_id',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'days_until_expiry' => 'integer',
    ];

    // Relationships
    public function stockItem(): BelongsTo
    {
        return $this->belongsTo(LabStockItem::class, 'stock_item_id');
    }

    public function notifiedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notified_user_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeCritical($query)
    {
        return $query->where('notification_type', 'critical_expiry');
    }

    public function scopeExpiringSoon($query)
    {
        return $query->where('notification_type', 'expiring_soon');
    }

    public function scopeExpired($query)
    {
        return $query->where('notification_type', 'expired');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('notified_user_id', $userId);
    }

    // Accessors
    public function getNotificationTypeLabelAttribute(): string
    {
        return match($this->notification_type) {
            'expiring_soon' => 'قريب الانتهاء',
            'critical_expiry' => 'انتهاء حرج',
            'expired' => 'منتهي الصلاحية',
            default => $this->notification_type,
        };
    }

    public function getPriorityAttribute(): int
    {
        return match($this->notification_type) {
            'expired' => 3,
            'critical_expiry' => 2,
            'expiring_soon' => 1,
            default => 0,
        };
    }

    // Methods
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notification) {
            if (!$notification->message) {
                $notification->message = self::generateDefaultMessage($notification);
            }
        });
    }

    private static function generateDefaultMessage($notification): string
    {
        $itemName = $notification->stockItem?->name ?? 'منتج غير معروف';

        return match($notification->notification_type) {
            'expired' => "المنتج '{$itemName}' انتهت صلاحيته",
            'critical_expiry' => "المنتج '{$itemName}' سينتهي خلال {$notification->days_until_expiry} يوم فقط",
            'expiring_soon' => "المنتج '{$itemName}' سينتهي خلال {$notification->days_until_expiry} يوم",
            default => "تنبيه بشأن المنتج '{$itemName}'",
        };
    }
}
