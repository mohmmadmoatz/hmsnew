<tr x-data="{ modalIsOpen : false }">

<td>{{$payments->wasl_number}}</td>

<td> <span class="@if($payments->payment_type ==1) text-danger @else text-success @endif">
    {{$payments->payment_type ==1 ?'صرف' :'قبض'}}

    @if($payments->redirect)
    <hr>
        {{$payments->stagename->name ??""}}
    @endif

</span> 
</td>
    <td> <span class="@if($payments->payment_type ==1) text-danger @else text-success @endif">
        @convert($payments->amount_usd)
        @if($payments->return_usd)
        <hr>
        <span class="text-danger"> مرجع : @convert($payments->return_usd) </span>
        @endif
    </span> </td>
    <td> <span class="@if($payments->payment_type ==1) text-danger @else text-success @endif">
        @convert($payments->amount_iqd)
        @if($payments->return_iqd)
        <hr>
       <span class="text-danger">مرجع : @convert($payments->return_iqd)</span>  
        @endif
    </span> 
    </td>
    <td> {{ $payments->user->name ?? "" }} </td>
    <td> 
    
    @if($payments->account_type==1) <span> طبيب <hr> {{ $payments->doctor->name ??""}} </span> @endif
    @if($payments->account_type==2) <span> مريض <hr> {{ $payments->Patient->name ??""}} </span> @endif
    @if($payments->account_type==3) <span> نقدي <hr> {{ $payments->account_name ??""}} </span> @endif

     </td>
    <td> {{ $payments->description }} </td>
    <td> {{ $payments->date }} </td>    
    @if(config('easy_panel.crud.payments.delete') or config('easy_panel.crud.payments.update'))
        <td>

            @if(config('easy_panel.crud.payments.update'))
                <a href="@route(getRouteName().'.payments.update', ['payments' => $payments->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>

            
                  <a  href="@route('printrecept')?id={{$payments->id}}" target="_blank" class="btn text-primary mt-1">
                    <i class="fa fa-print"></i>
                </a>

                
                

            @endif

            @if(config('easy_panel.crud.payments.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">حذف</h5>
                        <p>سوف يتم حذف السند</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it.') }}</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </td>
    @endif
</tr>
