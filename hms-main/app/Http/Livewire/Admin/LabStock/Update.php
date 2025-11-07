<?php

namespace App\Http\Livewire\Admin\LabStock;

use App\Models\LabStockItem;
use App\Models\LabStockCategory;
use Livewire\Component;

class Update extends Component
{
    public $itemId;
    public $name;
    public $code;
    public $category;
    public $description;
    public $quantity;
    public $min_quantity;
    public $unit_price;
    public $supplier;
    public $purchase_date;
    public $expiry_date;
    public $batch_number;
    public $location;
    public $notes;
    public $days_before_expiry_notification;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lab_stock_items,code,' . $this->itemId,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date|after:purchase_date',
            'batch_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'days_before_expiry_notification' => 'required|integer|min:1',
        ];
    }

    protected $messages = [
        'name.required' => 'اسم المنتج مطلوب',
        'code.required' => 'كود المنتج مطلوب',
        'code.unique' => 'كود المنتج موجود مسبقاً',
        'category.required' => 'الفئة مطلوبة',
        'quantity.required' => 'الكمية مطلوبة',
        'quantity.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
        'quantity.min' => 'الكمية يجب أن تكون أكبر من أو تساوي صفر',
        'unit_price.required' => 'سعر الوحدة مطلوب',
        'unit_price.numeric' => 'سعر الوحدة يجب أن يكون رقماً',
        'unit_price.min' => 'سعر الوحدة يجب أن يكون أكبر من أو يساوي صفر',
        'purchase_date.required' => 'تاريخ الشراء مطلوب',
        'expiry_date.required' => 'تاريخ الانتهاء مطلوب',
        'expiry_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ الشراء',
        'days_before_expiry_notification.required' => 'أيام التنبيه قبل الانتهاء مطلوبة',
        'days_before_expiry_notification.integer' => 'أيام التنبيه يجب أن تكون رقماً صحيحاً',
        'days_before_expiry_notification.min' => 'أيام التنبيه يجب أن تكون أكبر من صفر',
    ];

    public function mount($id)
    {
        $item = LabStockItem::findOrFail($id);
        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->code = $item->code;
        $this->category = $item->category;
        $this->description = $item->description;
        $this->quantity = $item->quantity;
        $this->min_quantity = $item->min_quantity;
        $this->unit_price = $item->unit_price;
        $this->supplier = $item->supplier;
        $this->purchase_date = $item->purchase_date->format('Y-m-d');
        $this->expiry_date = $item->expiry_date->format('Y-m-d');
        $this->batch_number = $item->batch_number;
        $this->location = $item->location;
        $this->notes = $item->notes;
        $this->days_before_expiry_notification = $item->days_before_expiry_notification;
    }

    public function updatedCode()
    {
        $this->validateOnly('code');
    }

    public function updatedQuantity()
    {
        $this->validateOnly('quantity');
    }

    public function updatedUnitPrice()
    {
        $this->validateOnly('unit_price');
    }

    public function updatedExpiryDate()
    {
        $this->validateOnly('expiry_date');
    }

    public function save()
    {
        $validatedData = $this->validate();

        $item = LabStockItem::findOrFail($this->itemId);

        // Check if quantity changed and create movement if needed
        $quantityDifference = $validatedData['quantity'] - $item->quantity;
        if ($quantityDifference != 0) {
            $movementType = $quantityDifference > 0 ? 'in' : 'out';
            $item->addMovement(
                $movementType,
                abs($quantityDifference),
                'تعديل الكمية',
                'تعديل الكمية من ' . $item->quantity . ' إلى ' . $validatedData['quantity']
            );
        }

        // Update item
        $validatedData['total_price'] = $validatedData['quantity'] * $validatedData['unit_price'];
        $item->update($validatedData);

        session()->flash('message', 'تم تحديث المنتج بنجاح');

        return redirect()->route('admin.labstock.read');
    }

    public function getCategoriesProperty()
    {
        return LabStockCategory::active()->ordered()->pluck('name');
    }

    public function render()
    {
        return view('livewire.admin.lab-stock.update', [
            'categories' => $this->categories,
        ])->layout('admin::layouts.app', ['title' => __(('تحديث منتج')) ]);
    }
}
