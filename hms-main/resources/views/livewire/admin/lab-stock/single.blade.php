<div>
    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0">
                    <h3 class="card-title">تفاصيل المنتج: {{ $item->name }}</h3>

                    <div class="px-2 mt-4">
                        <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                            <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="@route(getRouteName().'.labstock.read')" class="text-decoration-none">إدارة مخزون المختبر</a></li>
                            <li class="breadcrumb-item active">{{ $item->name }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Item Overview -->
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Basic Info -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">المعلومات الأساسية</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>الاسم:</strong></td>
                                                    <td>{{ $item->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>الكود:</strong></td>
                                                    <td>{{ $item->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>الفئة:</strong></td>
                                                    <td>{{ $item->category }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>المورد:</strong></td>
                                                    <td>{{ $item->supplier ?? 'غير محدد' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">الكمية والقيمة</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>الكمية:</strong></td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $item->quantity }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>الحد الأدنى:</strong></td>
                                                    <td>{{ $item->min_quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>سعر الوحدة:</strong></td>
                                                    <td>{{ number_format($item->unit_price, 2) }} دينار</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>إجمالي القيمة:</strong></td>
                                                    <td>{{ number_format($item->total_value, 2) }} دينار</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">الحالة والإجراءات</h6>

                                    <div class="mb-3">
                                        <strong>الحالة:</strong>
                                        @switch($item->status)
                                            @case('active')
                                                <span class="badge badge-success badge-lg">نشط</span>
                                                @break
                                            @case('low_stock')
                                                <span class="badge badge-warning badge-lg">مخزون منخفض</span>
                                                @break
                                            @case('expired')
                                                <span class="badge badge-danger badge-lg">منتهي الصلاحية</span>
                                                @break
                                            @case('out_of_stock')
                                                <span class="badge badge-dark badge-lg">نفد المخزون</span>
                                                @break
                                        @endswitch
                                    </div>

                                    @if($item->is_low_stock)
                                        <div class="alert alert-warning py-2">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            المخزون أقل من الحد الأدنى!
                                        </div>
                                    @endif

                                    <div class="btn-group-vertical w-100" x-data="{ modalIsOpen: false }">
                                        <a href="@route(getRouteName().'.labstock.update', $item->id)"
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> تحديث المنتج
                                        </a>
                                        <button @click="modalIsOpen = true; $wire.openMovementModal('in')"
                                                class="btn btn-success btn-sm">
                                            <i class="fa fa-plus"></i> إضافة كمية
                                        </button>
                                        <button @click="modalIsOpen = true; $wire.openMovementModal('out')"
                                                class="btn btn-danger btn-sm">
                                            <i class="fa fa-minus"></i> إخراج كمية
                                        </button>
                                        <button @click="modalIsOpen = true; $wire.openMovementModal('adjustment')"
                                                class="btn btn-info btn-sm">
                                            <i class="fa fa-balance-scale"></i> تعديل الكمية
                                        </button>
                                        <a href="@route(getRouteName().'.labstock.read')"
                                           class="btn btn-secondary btn-sm">
                                            <i class="fa fa-arrow-left"></i> العودة للقائمة
                                        </a>

                                        <!-- Movement Modal -->
                                        <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn"
                                             style="display: none;">
                                            <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false; $wire.closeMovementModal()" >
                                                <h5 class="pb-2 border-bottom">{{ __('Add Movement') }}</h5>
                                                <form wire:submit.prevent="addMovement">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="movementQuantity">الكمية <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control @error('movementQuantity') is-invalid @enderror"
                                                                       wire:model.live="movementQuantity" id="movementQuantity"
                                                                       min="1" placeholder="أدخل الكمية">
                                                                @error('movementQuantity')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="movementReason">السبب</label>
                                                                <input type="text" class="form-control @error('movementReason') is-invalid @enderror"
                                                                       wire:model="movementReason" id="movementReason"
                                                                       placeholder="سبب الحركة">
                                                                @error('movementReason')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="movementNotes">ملاحظات</label>
                                                        <textarea class="form-control @error('movementNotes') is-invalid @enderror"
                                                                  wire:model="movementNotes" id="movementNotes" rows="3"
                                                                  placeholder="ملاحظات إضافية..."></textarea>
                                                        @error('movementNotes')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    @if($movementQuantity && $item)
                                                        <div class="alert alert-info">
                                                            <strong>الكمية الحالية:</strong> {{ $item->quantity }}
                                                            <br>
                                                            <strong>الكمية الجديدة:</strong>
                                                            @if($movementType === 'in')
                                                                {{ $item->quantity + $movementQuantity }}
                                                            @elseif($movementType === 'out')
                                                                {{ max(0, $item->quantity - $movementQuantity) }}
                                                            @else
                                                                {{ $movementQuantity }}
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="mt-4 d-flex justify-content-between">
                                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                                            <span wire:loading.remove>
                                                                <i class="fa fa-save"></i> حفظ الحركة
                                                            </span>
                                                            <span wire:loading>
                                                                <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                                            </span>
                                                        </button>
                                                        <button @click="modalIsOpen = false; $wire.closeMovementModal()"
                                                                class="btn btn-secondary">
                                                            <i class="fa fa-times"></i> إلغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">تواريخ وموقع التخزين</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>تاريخ الشراء:</strong></td>
                                            <td>{{ $item->purchase_date->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاريخ الانتهاء:</strong></td>
                                            <td>
                                                {{ $item->expiry_date->format('d/m/Y') }}
                                                @if($item->days_until_expiry <= 7 && $item->days_until_expiry >= 0)
                                                    <span class="badge badge-danger ml-2">{{ $item->days_until_expiry }} يوم</span>
                                                @elseif($item->days_until_expiry <= 30 && $item->days_until_expiry > 7)
                                                    <span class="badge badge-warning ml-2">{{ $item->days_until_expiry }} يوم</span>
                                                @elseif($item->is_expired)
                                                    <span class="badge badge-dark ml-2">منتهي</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>رقم الدفعة:</strong></td>
                                            <td>{{ $item->batch_number ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>الموقع:</strong></td>
                                            <td>{{ $item->location ?? 'غير محدد' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">إعدادات التنبيه والملاحظات</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>أيام التنبيه:</strong></td>
                                            <td>{{ $item->days_before_expiry_notification }} يوم</td>
                                        </tr>
                                        <tr>
                                            <td><strong>حالة التنبيه:</strong></td>
                                            <td>
                                                @if($item->expiry_notification_sent)
                                                    <span class="badge badge-success">تم الإرسال</span>
                                                @else
                                                    <span class="badge badge-secondary">لم يتم الإرسال</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>أضيف بواسطة:</strong></td>
                                            <td>{{ $item->creator->name ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاريخ الإضافة:</strong></td>
                                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>

                                    @if($item->notes)
                                        <div class="mt-3">
                                            <strong>ملاحظات:</strong>
                                            <p class="text-muted mt-2">{{ $item->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="text-primary">{{ $stats['total_movements'] }}</h4>
                                    <p class="mb-0">إجمالي الحركات</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="text-success">{{ $stats['total_in'] }}</h4>
                                    <p class="mb-0">الكمية الواردة</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="text-danger">{{ $stats['total_out'] }}</h4>
                                    <p class="mb-0">الكمية الصادرة</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="text-info">
                                        @if($stats['last_movement'])
                                            {{ $stats['last_movement']->created_at->diffForHumans() }}
                                        @else
                                            لا توجد
                                        @endif
                                    </h4>
                                    <p class="mb-0">آخر حركة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Movement History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">سجل الحركات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>نوع الحركة</th>
                                    <th>الكمية</th>
                                    <th>الكمية السابقة</th>
                                    <th>الكمية الحالية</th>
                                    <th>السبب</th>
                                    <th>بواسطة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->movement_date->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @switch($movement->movement_type)
                                                @case('in')
                                                    <span class="badge badge-success">وارد</span>
                                                    @break
                                                @case('out')
                                                    <span class="badge badge-danger">صادر</span>
                                                    @break
                                                @case('adjustment')
                                                    <span class="badge badge-info">تعديل</span>
                                                    @break
                                                @case('transfer')
                                                    <span class="badge badge-warning">تحويل</span>
                                                    @break
                                                @case('return')
                                                    <span class="badge badge-primary">إرجاع</span>
                                                    @break
                                                @case('waste')
                                                    <span class="badge badge-dark">هدر</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <span class="badge @if($movement->is_increase) badge-success @else badge-danger @endif">
                                                @if($movement->is_increase)+@else-@endif{{ $movement->quantity }}
                                            </span>
                                        </td>
                                        <td>{{ $movement->previous_quantity }}</td>
                                        <td>{{ $movement->current_quantity }}</td>
                                        <td>{{ $movement->reason ?? 'غير محدد' }}</td>
                                        <td>{{ $movement->performed_by }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">لا توجد حركات مسجلة</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($recentMovements->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $recentMovements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
