<?php

namespace App\Http\Livewire\Admin\LabStock;

use App\Models\LabStockItem;
use App\Models\LabStockCategory;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $code;
    public $category;
    public $description;
    public $quantity;
    public $min_quantity = 10;
    public $unit_price;
    public $supplier;
    public $purchase_date;
    public $expiry_date;
    public $batch_number;
    public $location;
    public $notes;
    public $days_before_expiry_notification = 30;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:lab_stock_items,code',
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

    public function mount()
    {
        $this->purchase_date = now()->format('Y-m-d');
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

        $validatedData['created_by'] = auth()->id();
        $validatedData['total_price'] = $validatedData['quantity'] * $validatedData['unit_price'];

        $item = LabStockItem::create($validatedData);

        // Create initial stock movement
        $item->addMovement('in', $validatedData['quantity'], 'إضافة منتج جديد', 'إدخال أولي للمنتج');

        session()->flash('message', 'تم إضافة المنتج بنجاح');

        return redirect()->route('admin.labstock.read');
    }

    public function getCategoriesProperty()
    {
        return LabStockCategory::active()->ordered()->pluck('name');
    }

    public function render()
    {
        return view('livewire.admin.lab-stock.create', [
            'categories' => $this->categories,
        ])->layout('admin::layouts.app', ['title' => __(('إضافة منتج جديد')) ]);
    }
}
