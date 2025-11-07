<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">المواد</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">المواد</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                    @if( Auth::user()->user_type  == "stockmanagment" ||  Auth::user()->user_type  == "superadmin" )
                        @if(config('easy_panel.crud.warehouseitem.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.warehouseitem.create')" class="btn btn-success">اضافة مادة</a>
                        </div>
                        @endif
                        @endif
                        @if(config('easy_panel.crud.warehouseitem.search'))
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode')) wire:model.lazy="search" @else wire:model="search" @endif placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="">فلترة حسب تاريخ الانتهاء</label>
                            <select class="form-control" wire:model="expire">
                                <option value="">-- بدون --</option>
                                <option value="1">منتهية</option>
                                <option value="2">تبقى اقل من 30 يوم</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="">فلترة حسب الفئة</label>
                            <select class="form-control" wire:model="cat">
                                <option value="">-- بدون --</option>
                                @foreach(App\Models\Stockcat::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>الفئة</td>
                        <td style='cursor: pointer' wire:click="sort('name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Name') }} </td>
           
                        <td> {{ __('الكمية الواردة') }} </td>
                        <td> {{ __('الكمية المستهلكة') }} </td>
                        <td> {{ __('الكمية الباقية') }} </td>
                        <td> {{ __('السعر') }} </td>
                        <td> تاريخ الانتهاء </td>
                        
                        @if(config('easy_panel.crud.warehouseitem.delete') or config('easy_panel.crud.warehouseitem.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($warehouseitems as $warehouseitem)
                        @livewire('admin.warehouseitem.single', ['warehouseitem' => $warehouseitem], key($warehouseitem->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $warehouseitems->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
