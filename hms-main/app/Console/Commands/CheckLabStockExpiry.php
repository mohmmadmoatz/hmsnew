<?php

namespace App\Console\Commands;

use App\Models\LabStockItem;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckLabStockExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lab-stock:check-expiry {--days=30 : Days before expiry to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for lab stock items nearing expiry and send notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int) $this->option('days');

        $this->info("Checking for lab stock items expiring within {$days} days...");

        // Get items that are expiring soon
        $expiringItems = LabStockItem::expiringSoon($days)->get();

        $this->info("Found {$expiringItems->count()} items expiring soon");

        $notificationsSent = 0;

        foreach ($expiringItems as $item) {
            try {
                $item->checkAndSendExpiryNotification();
                $notificationsSent++;

                $this->line("✓ Checked expiry for: {$item->name} (expires: {$item->expiry_date->format('Y-m-d')})");
            } catch (\Exception $e) {
                $this->error("✗ Failed to check expiry for: {$item->name} - {$e->getMessage()}");
                Log::error("Lab Stock Expiry Check Failed", [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Check for already expired items and update their status
        $expiredItems = LabStockItem::where('expiry_date', '<', now())
            ->where('status', '!=', 'expired')
            ->get();

        $this->info("Found {$expiredItems->count()} expired items to update");

        foreach ($expiredItems as $item) {
            $item->update(['status' => 'expired']);
            $this->line("✓ Updated status for expired item: {$item->name}");
        }

        // Check for low stock items
        $lowStockItems = LabStockItem::whereColumn('quantity', '<=', 'min_quantity')
            ->where('status', '!=', 'low_stock')
            ->where('status', '!=', 'out_of_stock')
            ->get();

        $this->info("Found {$lowStockItems->count()} items with low stock");

        foreach ($lowStockItems as $item) {
            $newStatus = $item->quantity <= 0 ? 'out_of_stock' : 'low_stock';
            $item->update(['status' => $newStatus]);
            $this->line("✓ Updated low stock status for: {$item->name}");
        }

        $this->info("Lab stock expiry check completed successfully!");
        $this->info("Notifications sent: {$notificationsSent}");
        $this->info("Expired items updated: {$expiredItems->count()}");
        $this->info("Low stock items updated: {$lowStockItems->count()}");

        return 0;
    }
}
