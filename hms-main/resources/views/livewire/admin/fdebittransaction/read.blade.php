<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">وصولات الديون الثابتة</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">وصولات الديون الثابتة</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.fdebittransaction.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.fdebittransaction.create')" class="btn btn-success">سند صرف</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.fdebittransaction.search'))
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

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">فلترة حسب القائمة</label>
                                <select wire:model="category_id" class="form-control" id="category_id" name="category_id">
                                    <option value="">اختيار</option>
                                    @foreach(App\Models\FdebitCategory::get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">اجمالي المبلغ دينار</label>
                                <input type="text" class="form-control" value="@convert($total_amount_iqd)" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">اجمالي المبلغ دولار</label>
                                <input type="text" class="form-control" value="@convert($total_amount_usd)" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                           
                            <a class="btn btn-warning" href="@route('fixeddebit')?id={{$category_id}}&daterange={{$daterange}}" target="_blank" rel="noopener noreferrer">

    
                                <i class="fa fa-print"></i> طباعة كشف حساب
                           </a>
                         
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td> {{ __('Category Name') }} </td>
                        <td style='cursor: pointer' wire:click="sort('number')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'number') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'number') fa-sort-amount-up ml-2 @endif'></i> {{ __('Number') }} </td>
                        <td style='cursor: pointer' wire:click="sort('name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Name') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_iqd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_iqd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_iqd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_iqd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_usd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_usd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_usd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_usd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('exchange_rate')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'exchange_rate') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'exchange_rate') fa-sort-amount-up ml-2 @endif'></i> {{ __('Exchange_rate') }} </td>
                        <td style='cursor: pointer' wire:click="sort('notes')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'notes') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'notes') fa-sort-amount-up ml-2 @endif'></i> {{ __('Notes') }} </td>
                        <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'date') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'date') fa-sort-amount-up ml-2 @endif'></i> {{ __('Date') }} </td>
                        
                        @if(config('easy_panel.crud.fdebittransaction.delete') or config('easy_panel.crud.fdebittransaction.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($fdebittransactions as $fdebittransaction)
                        @livewire('admin.fdebittransaction.single', ['fdebittransaction' => $fdebittransaction], key($fdebittransaction->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $fdebittransactions->appends(request()->query())->links() }}
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