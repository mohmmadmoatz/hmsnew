<div class="row" x-data="{'expanded':false}" wire:poll.8750ms>
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">الحسابات</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')"
                                class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">الحسابات</li>
                    </ul>

                   

                    <div class="row justify-content-between mt-4 mb-4" x-data="{'account_type':@entangle('account_type')}">
                        @if(config('easy_panel.crud.payments.create'))
                        <div class="col-md-8 right-0">
                            <a href="@route(getRouteName().'.payments.create')?payment_type=1" class="btn btn-danger">سند صرف جديد</a>
                            <a href="@route(getRouteName().'.payments.create')?payment_type=2" class="btn btn-success">سند قبض جديد</a>
                            <a href="@route(getRouteName().'.payments.patstatement')" class="btn btn-secondary">عرض حساب المرضى </a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.payments.search'))
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                                    wire:model.lazy="search" @else wire:model="search" @endif
                                    placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin"></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 py-2">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                                    wire:model.lazy="idnumber" @else wire:model="idnumber" @endif
                                    placeholder="{{ __('بحث عن طريق رقم الوصل') }}" value="{{ request('idnumber') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="idnumber" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="idnumber"><i class="fas fa-spinner fa-spin"></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br>
                        </div>
                        

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <label>صرف | قبض</label>
                            <select class="form-control" wire:model="paytype">
                                <option value="">الجميع</option>
                                <option value="1">صرف</option>
                                <option value="2">قبض</option>
                            </select>
                        </div>
                        <div class="col-md-4" >
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
                         <div class="col-md-4">
                    <div class="form-group">
                        <label>نوع الحساب</label>
                        <select class="form-control" wire:model.lazy="account_type">
                                <option value="">يرجى اختيار نوع الحساب</option>
                                <option value="1">طبيب</option>
                                <option value="2">مريض</option>
                                <option value="3">نقدي</option>
                        </select>
                    </div>
                </div>
                        <div class="col-md-6" wire:ignore x-show="account_type ==2">
                            <label>المريض</label>
                            <select wire:model.lazy="patient_id" class="form-control selectpicker"
                                data-live-search="true">
                                <option value=""></option>
                               
                               
                                
                            </select>
                        </div>
                        <div class="col-md-6" wire:ignore x-show="account_type ==1">
                            <div class='form-group'>
                                <label for='inputdoctor_id' class=' control-label'>الطبيب</label>
                                
                                <select class="form-control selectpicker" data-live-search="true" wire:model="doctor_id">
                                    <option value="">يرجى اختيار طبيب</option>
                                    @foreach(App\Models\User::where('user_type','doctor')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
            
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>

                        <div class="col-md-6" wire:ignore x-show="account_type ==3">
                            <div class='form-group'>
                                <label for='inputdoctor_id' class=' control-label'>الأسم</label>
                                <input type="text" class="form-control" wire:model.lazy = "account_name">
                            </div>
                        </div>
                     

                        @endif
                        <div class="col-md-12">
                            <table class="table table-bordred">
                                <tr>
                                    <th>اجمالي القبض</th>
                                    <th>اجمالي الصرف</th>
                                    <th>الرصيد</th>
                                    @if(auth()->user()->user_type == 'superadmin')
                                    <th>الصندوق</th>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                
                                        @convert($total_income_iqd) دينار
                                       |
                                        @convert($total_income_usd) دولار
                
                                    </td>
                
                                    <td>
                
                                        @convert($total_expense_iqd) دينار  |   @convert($total_expense_usd) دولار
                                        
                                       
                
                                    </td>
                
                                    <td>
                
                                        @convert($total_income_iqd - $total_expense_iqd) دينار |  @convert($total_income_usd - $total_expense_usd) دولار
                                        
                
                
                                    </td>
                                    @if(auth()->user()->user_type == 'superadmin')
                                    <td>
                                        @php
                                        $setting = App\Models\Setting::find(1);
                                        
                                        $debit = App\Models\Payments::where("date",">",$setting->box_date)
                                        ->where("payment_type",2)
                                        ->sum("amount_iqd");

                                        $debit_usd = App\Models\Payments::where("date",">",$setting->box_date)
                                        ->where("payment_type",2)
                                        ->sum("amount_usd");

                                        $credit = App\Models\Payments::where("date",">",$setting->box_date)
                                        ->where("payment_type",1)
                                        ->sum("amount_iqd");

                                        $credit_usd = App\Models\Payments::where("date",">",$setting->box_date)
                                        ->where("payment_type",1)
                                        ->sum("amount_usd");
                                        
                                        @endphp

                                        <a href="@route('balance')">
                                            @convert($debit - $credit) د.ع | 
                                            @convert($debit_usd - $credit_usd) $
                                        </a>

                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <style>
 .table.table-fit {
    width: max-content !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}
                
        </style>
            <div class="card-body table-responsive p-0">
                
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td> {{ __('رقم الوصل') }} </td>
                            <td> {{ __('نوع السند') }} </td>
                            <td> دولار </td>
                            <td> دينار </td>
                            <td> {{ __('User Name') }} </td>
                            <td> {{ __('الحساب') }} </td>
                            <td style='cursor: pointer' wire:click="sort('description')"> <i
                                    class='fa @if($sortType == ' desc' and $sortColumn=='description' )
                                    fa-sort-amount-down ml-2 @elseif($sortType=='asc' and $sortColumn=='description' )
                                    fa-sort-amount-up ml-2 @endif'></i> {{ __('وذالك عن') }} </td>
                            <td style='cursor: pointer' wire:click="sort('date')"> <i class='fa @if($sortType == ' desc'
                                    and $sortColumn=='date' ) fa-sort-amount-down ml-2 @elseif($sortType=='asc' and
                                    $sortColumn=='date' ) fa-sort-amount-up ml-2 @endif'></i> {{ __('التاريخ') }} </td>
                            @if(config('easy_panel.crud.payments.delete') or config('easy_panel.crud.payments.update'))
                            <td>{{ __('Action') }}</td>
                            @endif
                        </tr>

                        @foreach($paymentss as $payments)
                        @livewire('admin.payments.single', ['payments' => $payments], key($payments->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $paymentss->appends(request()->query())->links() }}
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