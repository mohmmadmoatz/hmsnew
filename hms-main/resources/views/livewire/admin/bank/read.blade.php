<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">سحوبات الخزنة</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">سحوبات الخزنة</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.bank.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.bank.create')" class="btn btn-success">سحب جديد</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.bank.search'))
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
                        </div>

                        <div class="col-md-12" >
                            <label for="">الفترة

                            <a wire:target="daterange" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="daterange"><i class="fas fa-spinner fa-spin"></i></a>

                            </label>
                            <div class="input-group">
                                <input onchange="daterangeGo()" autocomplete="off" type="text" id="reportrange" class="form-control" wire:model.lazy="daterange"
                                    wire:ignore>

                                <div class="input-group-append">
                                    
                                    @if($datefilterON)
                                    <button class="btn btn-danger" wire:click="$set('datefilterON',false)">
                                        الغاء
                                    </button>
                                    @endif

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                                    <label for="">اجمالي السحب (دينار)</label>
                                    <input readonly type="text" class="form-control" value = "@convert($total)">    
                        </div>
                        <div class="col-md-6">
                                    <label for="">اجمالي السحب (دولار)</label>
                                    <input readonly type="text" class="form-control" value = "@convert($total_usd)">    
                        </div>

                        <div class="col-md-12 mt-3">
                            <a href = "@route('bankreport')?daterange={{$daterange}}" class="btn btn-warning">طباعة كشف</a>
                        </div>

                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td style='cursor: pointer' wire:click="sort('wasl_number')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'wasl_number') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'wasl_number') fa-sort-amount-up ml-2 @endif'></i> {{ __('Wasl_number') }} </td>
                        <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'date') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'date') fa-sort-amount-up ml-2 @endif'></i> {{ __('Date') }} </td>
                        <td style='cursor: pointer' wire:click="sort('description')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'description') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'description') fa-sort-amount-up ml-2 @endif'></i> {{ __('Description') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_iqd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_iqd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_iqd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_iqd') }} </td>
                        <td style='cursor: pointer' wire:click="sort('amount_usd')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'amount_usd') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'amount_usd') fa-sort-amount-up ml-2 @endif'></i> {{ __('Amount_usd') }} </td>
                        
                        @if(config('easy_panel.crud.bank.delete') or config('easy_panel.crud.bank.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($banks as $bank)
                        @livewire('admin.bank.single', ['bank' => $bank], key($bank->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $banks->appends(request()->query())->links() }}
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