<?php

namespace App\Http\Livewire\Admin\LabStock;

use App\Models\LabStockItem;
use App\Models\LabStockCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $expiryFilter = '';
    public $perPage = 20;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'expiryFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingExpiryFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $item = LabStockItem::findOrFail($id);
        $item->delete();

        session()->flash('message', 'تم حذف المنتج بنجاح');
        $this->dispatch('item-deleted');
    }

    public function getItemsProperty()
    {
        return LabStockItem::query()
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('supplier', 'like', '%' . $this->search . '%')
                      ->orWhere('batch_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function (Builder $query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when($this->statusFilter, function (Builder $query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->expiryFilter, function (Builder $query) {
                switch ($this->expiryFilter) {
                    case 'expired':
                        $query->where('expiry_date', '<', now());
                        break;
                    case 'expiring_soon':
                        $query->where('expiry_date', '<=', now()->addDays(30))
                              ->where('expiry_date', '>=', now());
                        break;
                    case 'expiring_week':
                        $query->where('expiry_date', '<=', now()->addDays(7))
                              ->where('expiry_date', '>=', now());
                        break;
                    case 'safe':
                        $query->where('expiry_date', '>', now()->addDays(30));
                        break;
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        return LabStockCategory::active()->ordered()->get();
    }

    public function getStatsProperty()
    {
        $totalItems = LabStockItem::count();
        $lowStockItems = LabStockItem::lowStock()->count();
        $expiredItems = LabStockItem::expired()->count();
        $expiringSoonItems = LabStockItem::expiringSoon()->count();
        $totalValue = LabStockItem::sum('total_price');

        return [
            'total_items' => $totalItems,
            'low_stock_items' => $lowStockItems,
            'expired_items' => $expiredItems,
            'expiring_soon_items' => $expiringSoonItems,
            'total_value' => $totalValue,
        ];
    }

    public function render()
    {
        return view('livewire.admin.lab-stock.read', [
            'items' => $this->items,
            'categories' => $this->categories,
            'stats' => $this->stats,
        ])->layout('admin::layouts.app', ['title' => __(('مخزن المختبر')) ]);
    }
}
