<div class="row" wire:poll.7000ms>
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">قائمة العمليات</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">العمليات</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.operationhold.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.operationhold.create')" class="btn btn-success">{{ __('CreateTitle', ['name' => __('OperationHold') ]) }}</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.operationhold.search'))
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
                     
                        <div class="col-md-4">
                            <label for="">الفترة</label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" id="reportrange" onchange="daterangeGo()"  class="form-control" wire:model.lazy="daterange"
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

                            <div class="col-md-8">
                                <label for="">اشعار بتهئية مريض</label>
                                 <select class="form-control" wire:model.lazy="room">
                                        <option value="">يرجى اختيار المريض</option>
                                        @foreach(App\Models\Room::where("patient_id","!=",0)->get() as $item)
                                        <option @if($item->nt_at) disabled style="color:red" @endif value="{{$item->id}}"> {{$item->name}} ({{$item->user->name ??""}}) </option>
                                        @endforeach
                                 </select>
                                 <button class="btn btn-danger" wire:click="notify({{$room}})">اشعار</button>
                            </div>

                            <div class="col-md-12 mt-4">
                                <a href="@route('opreport')?daterange={{$daterange}}" class="btn btn-warning btn-block">طباعة </a>
                            </div>
                            
                      
                        @endif
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

.table{
    width: 100%;
    margin-bottom: 1rem;
    color: #000000;
    background: #8080806b;
}
                
        </style>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped ">
                    <tbody>
                    <tr>
                        <td> رقم العملية</td>
                        <td> التاريخ</td>
                        
                        <td style='cursor: pointer' wire:click="sort('patinet_id')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'patinet_id') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'patinet_id') fa-sort-amount-up ml-2 @endif'></i> {{ __('المريض') }} </td>
                        <td class="fit" style='cursor: pointer' wire:click="sort('doctor_id')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'doctor_id') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'doctor_id') fa-sort-amount-up ml-2 @endif'></i> {{ __('الطبيب') }} </td>
                        <td style='cursor: pointer' wire:click="sort('operation_name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'operation_name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'operation_name') fa-sort-amount-up ml-2 @endif'></i> {{ __('اسم العملية') }} </td>
                        
                        <td>مصاريف العملية</td>

                        @if(config('easy_panel.crud.operationhold.delete') or config('easy_panel.crud.operationhold.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($operationholds as $operationhold)
                    <tr x-data="{ modalIsOpen : false}">

                    
                    <td> {{ $operationhold->id }} </td>
                    <td> {{ $operationhold->date }} </td>
                    <td> {{ $operationhold->Patient->name ??"" }} </td>
                    <td> {{ $operationhold->doctor->name ?? "" }} </td>
                    
                    <td> {{$operationhold->operation_name}} </td>
                    
                    <td>
                    @if(!$operationhold->ware_id)
    <a  target="_blank" href="@route(getRouteName().'.operationhold.exp')?opid={{$operationhold->id}}" class="btn btn-danger">مصاريف العملية</a> 
    @else
    <a  target="_blank" href="@route(getRouteName().'.warehouseexport.update', ['warehouseexport' => $operationhold->ware_id])" class="btn btn-warning">مصاريف العملية</a>
    @endif
                    </td>

                    <td>
                      

                        <a  href="@route(getRouteName().'.lab.read')?patient_id={{$operationhold->Patient->id??''}}" target="_blank" >الفحوصات</a>
                        | <a  href="@route('printedForm')?id={{$operationhold->Patient->id??''}}" target="_blank" >فتح الطبلة</a>
                        @if($operationhold->hide)
                        <span class="badge badge-success">
                        {{$operationhold->Patient->room->name ??""}}
                        </span>
                        <a href="#hide" wire:click="undo({{$operationhold->id}})"><i class="fa fa-undo"></i></a>
                        @else

                
                        
                        <button @click.prevent="modalIsOpen = true" class="btn text-success mt-1">
                            <i class="icon-check"></i>
                        </button>
                        <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                            <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                                <h5 class="pb-2 border-bottom">تأكيد</h5>
                                <p>{{ __('DeleteMessage', ['name' => __('Patient') ]) }}</p>
                                <div class="mt-5 d-flex justify-content-between">
                                    <a @click.prevent="modalIsOpen = false" wire:click.prevent="hide({{$operationhold->id}})" class="text-white btn btn-success shadow">موافق</a>
                                    <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                     
                    </td>
                    
</tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $operationholds->appends(request()->query())->links() }}
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
