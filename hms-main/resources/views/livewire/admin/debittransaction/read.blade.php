<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">نظام الديون المتغيرة</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">وصولات الديون المتغيرة</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.debittransaction.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.debittransaction.create')" class="btn btn-success">انشاء</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.debittransaction.search'))
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
                        <div class="col-md-4" >
                            
                            <div class="input-group">
                                <input  autocomplete="off" type="text" id="reportrange" class="form-control" wire:model.lazy="daterange"
                                    >

                                <div class="input-group-append">
                                    
                                    <button class="btn btn-info" onclick="daterangeGo()">
                                        <a wire:target="daterange" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="datefilterON"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>

                                    @if($datefilterON)
                                    <button class="btn btn-danger" wire:click="$set('datefilterON',false)">
                                        الغاء
                                    </button>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mt-3">
                            <div class='form-group' wire:ignore>
                                <label for='inputaccount_id' class=' control-label'> {{ __('Account_id') }}</label>
                                
                               
                                    <select name='account_id' class='form-control selectpicker' wire:model='account_id' data-live-search="true">
                                        <option value="">يرجى اختيار الحساب</option>
                                        @foreach(App\Models\DebitAccount::get() as $account)
                                            <option value='{{ $account->id }}'>{{ $account->name }} ({{$account->balance ?? 0}})</option>
                                        @endforeach
                                    </select>
                
                               
                                @error('account_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                            </div>
                        </div>
                       
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>اجمالي الدين</th>
                                <th>اجمالي المدفوع</th>
                                <th>اجمالي المتبقي</th>
                            </tr>
                            <tr>
                                <td>
                                    @convert($total_debit_iqd) د.ع 
                                    |
                                    @convert($total_debit_usd) دولار
                                </td>

                                <td style="color: green;">
                                    @convert($total_credit_iqd) د.ع 
                                   |
                                    @convert($total_credit_usd) دولار
                                </td>

                                <td style="color: red">
                                    @convert($remaining_balance_iqd) د.ع 
                                    |
                                    @convert($remaining_balance_usd) دولار
                                </td>
                               
                        </table>

                        @if($account_id)
                        <div class="col-md-12">
                            <a class="btn btn-warning" href="@route('debitaccount')?id={{$account_id}}&daterange={{$daterange}}" target="_blank" rel="noopener noreferrer">

    
                                <i class="fa fa-print"></i> طباعة كشف حساب
                        </a>
                        </div>
                        @endif

                       

                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td style='cursor: pointer' wire:click="sort('number')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'number') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'number') fa-sort-amount-up ml-2 @endif'></i> {{ __('وصل القبض') }} </td>
                        <td style='cursor: pointer' wire:click="sort('number')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'number') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'number') fa-sort-amount-up ml-2 @endif'></i> {{ __('وصل الصرف') }} </td>
                        <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'date') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'date') fa-sort-amount-up ml-2 @endif'></i> {{ __('Date') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_iqd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_iqd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_iqd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_iqd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_usd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_usd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_usd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_usd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Name') }} </td>
                        <td style='cursor: pointer' wire:click="sort('notes')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'notes') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'notes') fa-sort-amount-up ml-2 @endif'></i> {{ __('Notes') }} </td>
                        <td style='cursor: pointer' wire:click="sort('payment_type')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'payment_type') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'payment_type') fa-sort-amount-up ml-2 @endif'></i> {{ __('Payment_type') }} </td>
                        <td style='cursor: pointer' wire:click="sort('file')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'file') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'file') fa-sort-amount-up ml-2 @endif'></i> {{ __('File') }} </td>
                        <td> {{ __('Account Name') }} </td>
                        
                        @if(config('easy_panel.crud.debittransaction.delete') or config('easy_panel.crud.debittransaction.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($debittransactions as $debittransaction)
                        @livewire('admin.debittransaction.single', ['debittransaction' => $debittransaction], key($debittransaction->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $debittransactions->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
<script>
    function daterangeGo() {
        var element = document.getElementById("reportrange")
        console.log(element.value)
        Livewire.emit('searchBydate');
        @this.searchBydate(element.value)
    }
</script>