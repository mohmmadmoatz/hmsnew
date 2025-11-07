<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Saveaccount')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Saveaccount')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.saveaccount.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.saveaccount.create')" class="btn btn-success">انشاء</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.saveaccount.search'))
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
                        <div class="col-md-12">
                            <hr>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>
                                        اجمالي الايداع
                                    </th>
                                    <th>
                                        اجمالي السحب
                                    </th>
                                    
                                    <th>
                                        الرصيد
                                    </th>

                                </tr>
                                <tr>
                                    <td>
                                        @convert($total_deposit_iqd) د.ع
                                        <hr>
                                        @convert($total_deposit_usd) $
                                        
                                    </td>
                                    <td>
                                        @convert($total_withdraw_iqd) د.ع
                                        <hr>
                                        @convert($total_withdraw_usd) $
                                    </td>
                                    <td>
                                        @convert($total_deposit_iqd - $total_withdraw_iqd) د.ع
                                        <hr>
                                        @convert($total_deposit_usd - $total_withdraw_usd) $
                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>



            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                         <td style='cursor: pointer' wire:click="sort('type')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'type') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'type') fa-sort-amount-up ml-2 @endif'></i> {{ __('Type') }} </td>
                        <td > رقم الوصل</td>
                        <td style='cursor: pointer' wire:click="sort('amount_iqd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_iqd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_iqd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_iqd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_usd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_usd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_usd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_usd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'date') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'date') fa-sort-amount-up ml-2 @endif'></i> {{ __('Date') }} </td>
                        <td style='cursor: pointer' wire:click="sort('details')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'details') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'details') fa-sort-amount-up ml-2 @endif'></i> {{ __('Details') }} </td>
                        <td> {{ __('User Name') }} </td>
                        
                        @if(config('easy_panel.crud.saveaccount.delete') or config('easy_panel.crud.saveaccount.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($saveaccounts as $saveaccount)
                        @livewire('admin.saveaccount.single', ['saveaccount' => $saveaccount], key($saveaccount->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $saveaccounts->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
