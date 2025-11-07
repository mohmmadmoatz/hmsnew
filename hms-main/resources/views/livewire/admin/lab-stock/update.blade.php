<div>
    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0">
                    <h3 class="card-title">تحديث منتج</h3>

                    <div class="px-2 mt-4">
                        <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                            <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="@route(getRouteName().'.labstock.read')" class="text-decoration-none">إدارة مخزون المختبر</a></li>
                            <li class="breadcrumb-item active">تحديث منتج</li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save" class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">المعلومات الأساسية</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               wire:model.live.debounce.300ms="name" id="name"
                                               placeholder="أدخل اسم المنتج">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="code" class="form-label">كود المنتج <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                               wire:model.live.debounce.300ms="code" id="code"
                                               placeholder="أدخل كود المنتج الفريد">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="category" class="form-label">الفئة <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category') is-invalid @enderror"
                                                wire:model.live="category" id="category">
                                            <option value="">اختر الفئة</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat }}">{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">الوصف</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  wire:model="description" id="description" rows="3"
                                                  placeholder="وصف المنتج..."></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity & Pricing -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">الكمية والتسعير</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="quantity" class="form-label">الكمية <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                                       wire:model.live.debounce.300ms="quantity" id="quantity"
                                                       min="0" placeholder="0">
                                                @error('quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="min_quantity" class="form-label">الحد الأدنى</label>
                                                <input type="number" class="form-control @error('min_quantity') is-invalid @enderror"
                                                       wire:model.live="min_quantity" id="min_quantity"
                                                       min="0">
                                                @error('min_quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="unit_price" class="form-label">سعر الوحدة (دينار) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('unit_price') is-invalid @enderror"
                                               wire:model.live.debounce.300ms="unit_price" id="unit_price"
                                               min="0" step="0.01" placeholder="0.00">
                                        @error('unit_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if($quantity && $unit_price)
                                        <div class="alert alert-info">
                                            <strong>إجمالي القيمة:</strong> {{ number_format($quantity * $unit_price, 2) }} دينار
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Supplier & Dates -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">المورد والتواريخ</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="supplier" class="form-label">المورد</label>
                                        <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                               wire:model="supplier" id="supplier"
                                               placeholder="اسم المورد">
                                        @error('supplier')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="purchase_date" class="form-label">تاريخ الشراء <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                                       wire:model.live="purchase_date" id="purchase_date">
                                                @error('purchase_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="expiry_date" class="form-label">تاريخ الانتهاء <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                                       wire:model.live.debounce.300ms="expiry_date" id="expiry_date">
                                                @error('expiry_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="batch_number" class="form-label">رقم الدفعة</label>
                                        <input type="text" class="form-control @error('batch_number') is-invalid @enderror"
                                               wire:model="batch_number" id="batch_number"
                                               placeholder="رقم دفعة المنتج">
                                        @error('batch_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Settings -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">الموقع والإعدادات</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="location" class="form-label">الموقع</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                                               wire:model="location" id="location"
                                               placeholder="مكان تخزين المنتج">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="days_before_expiry_notification" class="form-label">
                                            أيام التنبيه قبل الانتهاء <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control @error('days_before_expiry_notification') is-invalid @enderror"
                                               wire:model.live="days_before_expiry_notification" id="days_before_expiry_notification"
                                               min="1">
                                        <small class="form-text text-muted">عدد الأيام قبل تاريخ الانتهاء لإرسال التنبيه</small>
                                        @error('days_before_expiry_notification')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="notes" class="form-label">ملاحظات</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                                  wire:model="notes" id="notes" rows="3"
                                                  placeholder="ملاحظات إضافية..."></textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <a href="@route(getRouteName().'.labstock.read')" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> العودة
                                        </a>
                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                <i class="fa fa-save"></i> حفظ التغييرات
                                            </span>
                                            <span wire:loading>
                                                <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">جاري الحفظ...</span>
                    </div>
                    <p class="mt-2">جاري حفظ التغييرات...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:loading', () => {
    $('#loadingModal').modal('show');
});

document.addEventListener('livewire:loaded', () => {
    $('#loadingModal').modal('hide');
});
</script>
