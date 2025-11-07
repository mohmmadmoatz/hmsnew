<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Warehouse')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Warehouse')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.warehouse.create'))

                        @if( Auth::user()->user_type  == "stockmanagment" ||  Auth::user()->user_type  == "superadmin" )
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.warehouse.create')" class="btn btn-success">اضافة</a>
                        </div>
                        @endif
                        

                        @endif
                        @if(config('easy_panel.crud.warehouse.search'))
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
                        <div class="col-md-4">
                            <div class="input-group" wire:ignore>
                           
                                <select data-live-search="true" class="form-control selectpicker" wire:model.lazy="product">
                                    <option value="">كشف حسب المادة</option>
                                    @foreach(App\Models\Warehouseproduct::get()  as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td style='cursor: pointer' wire:click="sort('supplier_name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'supplier_name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'supplier_name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Supplier_name') }} </td>
                        <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'date') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'date') fa-sort-amount-up ml-2 @endif'></i> {{ __('Date') }} </td>
                        <td style='cursor: pointer' wire:click="sort('menu_no')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'menu_no') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'menu_no') fa-sort-amount-up ml-2 @endif'></i> {{ __('Menu_no') }} </td>
                        <td style='cursor: pointer' wire:click="sort('menu_no')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'menu_no') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'menu_no') fa-sort-amount-up ml-2 @endif'></i> {{ __('اجمالي القائمة') }} </td>
                        <td style='cursor: pointer' wire:click="sort('address')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'address') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'address') fa-sort-amount-up ml-2 @endif'></i> {{ __('Address') }} </td>
                        <td style='cursor: pointer' wire:click="sort('phone')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'phone') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'phone') fa-sort-amount-up ml-2 @endif'></i> {{ __('Phone') }} </td>
                        <td> {{ __('User Name') }} </td>
                        
                        @if(config('easy_panel.crud.warehouse.delete') or config('easy_panel.crud.warehouse.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($warehouses as $warehouse)
                        @livewire('admin.warehouse.single', ['warehouse' => $warehouse], key($warehouse->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $warehouses->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
