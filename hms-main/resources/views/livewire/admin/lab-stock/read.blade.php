<div>
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['total_items']) }}</h4>
                            <p class="mb-0">إجمالي الأصناف</p>
                        </div>
                        <div class="ms-3">
                            <i class="fa fa-boxes fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['low_stock_items']) }}</h4>
                            <p class="mb-0">مخزون منخفض</p>
                        </div>
                        <div class="ms-3">
                            <i class="fa fa-exclamation-triangle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['expired_items']) }}</h4>
                            <p class="mb-0">منتهي الصلاحية</p>
                        </div>
                        <div class="ms-3">
                            <i class="fa fa-times-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['expiring_soon_items']) }}</h4>
                            <p class="mb-0">قريب الانتهاء</p>
                        </div>
                        <div class="ms-3">
                            <i class="fa fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Value Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['total_value'], 2) }} دينار</h4>
                            <p class="mb-0">إجمالي قيمة المخزون</p>
                        </div>
                        <div class="ms-3">
                            <i class="fa fa-dollar-sign fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0">
                    <h3 class="card-title">إدارة مخزون المختبر</h3>

                    <div class="px-2 mt-4">
                        <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                            <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إدارة مخزون المختبر</li>
                        </ul>

                        <div class="row justify-content-between mt-4 mb-4">
                            <div class="col-md-6">
                                <a href="@route(getRouteName().'.labstock.create')" class="btn btn-success">
                                    <i class="fa fa-plus"></i> إضافة منتج جديد
                                </a>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                                           placeholder="البحث في الأصناف..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-control" wire:model.live="categoryFilter">
                                    <option value="">جميع الفئات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" wire:model.live="statusFilter">
                                    <option value="">جميع الحالات</option>
                                    <option value="active">نشط</option>
                                    <option value="low_stock">مخزون منخفض</option>
                                    <option value="expired">منتهي الصلاحية</option>
                                    <option value="out_of_stock">نفد المخزون</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" wire:model.live="expiryFilter">
                                    <option value="">جميع تواريخ الانتهاء</option>
                                    <option value="expired">منتهي الصلاحية</option>
                                    <option value="expiring_soon">ينتهي خلال 30 يوم</option>
                                    <option value="expiring_week">ينتهي خلال أسبوع</option>
                                    <option value="safe">آمن (أكثر من 30 يوم)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" wire:model.live="perPage">
                                    <option value="10">10 عنصر</option>
                                    <option value="20">20 عنصر</option>
                                    <option value="50">50 عنصر</option>
                                    <option value="100">100 عنصر</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="cursor: pointer" wire:click="sortBy('name')">
                                    <i class="fa @if($sortDirection == 'desc' && $sortField == 'name') fa-sort-amount-down @else fa-sort-amount-up @endif ml-2"></i>
                                    اسم المنتج
                                </th>
                                <th style="cursor: pointer" wire:click="sortBy('code')">
                                    <i class="fa @if($sortDirection == 'desc' && $sortField == 'code') fa-sort-amount-down @else fa-sort-amount-up @endif ml-2"></i>
                                    الكود
                                </th>
                                <th>الفئة</th>
                                <th style="cursor: pointer" wire:click="sortBy('quantity')">
                                    <i class="fa @if($sortDirection == 'desc' && $sortField == 'quantity') fa-sort-amount-down @else fa-sort-amount-up @endif ml-2"></i>
                                    الكمية
                                </th>
                                <th>الحد الأدنى</th>
                                <th style="cursor: pointer" wire:click="sortBy('expiry_date')">
                                    <i class="fa @if($sortDirection == 'desc' && $sortField == 'expiry_date') fa-sort-amount-down @else fa-sort-amount-up @endif ml-2"></i>
                                    تاريخ الانتهاء
                                </th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="{{ $item->is_expired ? 'table-danger' : ($item->is_expiring_soon ? 'table-warning' : '') }}">
                                    <td>
                                        <a href="@route(getRouteName().'.labstock.single', $item->id)" class="text-decoration-none">
                                            {{ $item->name }}
                                        </a>
                                        @if($item->is_low_stock)
                                            <span class="badge badge-warning ml-2">مخزون منخفض</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->quantity }}</span>
                                        @if($item->quantity <= $item->min_quantity)
                                            <i class="fa fa-exclamation-triangle text-warning ml-1" title="مخزون منخفض"></i>
                                        @endif
                                    </td>
                                    <td>{{ $item->min_quantity }}</td>
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
                                    <td>
                                        @switch($item->status)
                                            @case('active')
                                                <span class="badge badge-success">نشط</span>
                                                @break
                                            @case('low_stock')
                                                <span class="badge badge-warning">مخزون منخفض</span>
                                                @break
                                            @case('expired')
                                                <span class="badge badge-danger">منتهي الصلاحية</span>
                                                @break
                                            @case('out_of_stock')
                                                <span class="badge badge-dark">نفد المخزون</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="@route(getRouteName().'.labstock.single', $item->id)" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="@route(getRouteName().'.labstock.update', $item->id)" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button wire:click="delete({{ $item->id }})"
                                                    wire:confirm="هل أنت متأكد من حذف هذا المنتج؟"
                                                    class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">لا توجد منتجات في المخزون</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="card-footer">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
