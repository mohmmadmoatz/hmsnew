<tr x-data="{ modalIsOpen : false }">
    <td>
        <!-- Check if is checked or not  -->
      
        @if($debittransaction->payment_type == 2 && $debittransaction->checked == 1)
            <i class = "fa fa-check"></i>
        @endif

        @if($debittransaction->payment_type == 2 && $debittransaction->checked != 1)
        <a href="@route(getRouteName().'.debittransaction.create')?payment_type=1&number={{$debittransaction->id}}">صرف</a>
        @endif
      

        {{ $debittransaction->number }} 


    </td>
    <td>
    {{ $debittransaction->wasl_number }} 
    </td>
    <td> {{ $debittransaction->date }} </td>
    <td> @convert($debittransaction->amount_iqd) </td>
    <td> @convert($debittransaction->amount_usd) </td>
    <td> {{ $debittransaction->name }} </td>
    <td> {{ $debittransaction->notes }} </td>
    <td> 
        @if($debittransaction->payment_type == 1)
        <span style="font-size:15px" class="badge badge-success">صرف</span>
        @elseif($debittransaction->payment_type == 2)
        <span style="font-size:15px" class="badge badge-danger">قبض</span>
        @endif
      

                
  

    </td>
    <td> {{ $debittransaction->file }} </td>
    <td> {{ $debittransaction->account->name ?? "" }} </td>    
    @if(config('easy_panel.crud.debittransaction.delete') or config('easy_panel.crud.debittransaction.update'))
        <td>

            @if(config('easy_panel.crud.debittransaction.update'))
                <a href="@route(getRouteName().'.debittransaction.update', ['debittransaction' => $debittransaction->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.debittransaction.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('DebitTransaction') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('DebitTransaction') ]) }}</p>
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
