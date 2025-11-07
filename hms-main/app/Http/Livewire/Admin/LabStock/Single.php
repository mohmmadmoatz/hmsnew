<?php

namespace App\Http\Livewire\Admin\LabStock;

use App\Models\LabStockItem;
use App\Models\LabStockMovement;
use Livewire\Component;
use Livewire\WithPagination;

class Single extends Component
{
    use WithPagination;

    public $itemId;
    public $movementType = 'in';
    public $movementQuantity;
    public $movementReason;
    public $movementNotes;

    protected $rules = [
        'movementQuantity' => 'required|integer|min:1',
        'movementReason' => 'nullable|string|max:255',
        'movementNotes' => 'nullable|string',
    ];

    protected $messages = [
        'movementQuantity.required' => 'الكمية مطلوبة',
        'movementQuantity.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
        'movementQuantity.min' => 'الكمية يجب أن تكون أكبر من صفر',
        'movementReason.max' => 'سبب الحركة يجب أن يكون أقل من 255 حرف',
        'movementNotes.max' => 'ملاحظات الحركة يجب أن تكون أقل من 255 حرف',
    ];

    public function mount($id)
    {
        $this->itemId = $id;
    }

    public function openMovementModal($type = 'in')
    {
        $this->movementType = $type;
        $this->movementQuantity = null;
        $this->movementReason = null;
        $this->movementNotes = null;
    }

    public function closeMovementModal()
    {
        $this->reset(['movementQuantity', 'movementReason', 'movementNotes']);
    }

    public function addMovement()
    {
        $this->validate();

        $item = LabStockItem::findOrFail($this->itemId);

        $item->addMovement(
            $this->movementType,
            $this->movementQuantity,
            $this->movementReason,
            $this->movementNotes
        );

        session()->flash('message', 'تم إضافة حركة المخزون بنجاح');

        $this->closeMovementModal();
     //   $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('LabSetting') ]) ]);

        $this->dispatchBrowserEvent('movement-added');
    }

    public function getItemProperty()
    {
        return LabStockItem::with(['movements' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }, 'creator'])->findOrFail($this->itemId);
    }

    public function getRecentMovementsProperty()
    {
        return LabStockMovement::where('stock_item_id', $this->itemId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getStatsProperty()
    {
        $item = $this->item;

        return [
            'total_movements' => $item->movements()->count(),
            'total_in' => $item->movements()->inMovements()->sum('quantity'),
            'total_out' => $item->movements()->outMovements()->sum('quantity'),
            'last_movement' => $item->movements()->latest()->first(),
            'expiry_status' => $item->is_expired ? 'expired' : ($item->is_expiring_soon ? 'expiring_soon' : 'safe'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.lab-stock.single', [
            'item' => $this->item,
            'recentMovements' => $this->recentMovements,
            'stats' => $this->stats,
        ])->layout('admin::layouts.app', ['title' => __(('تفاصيل المنتج')) ]);
    }
}
