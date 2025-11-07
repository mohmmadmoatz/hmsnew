<tr x-data="{ modalIsOpen : false }">
    <td> {{ $fdebittransaction->category->name ??""}} </td>
    <td> {{ $fdebittransaction->number }} </td>
    <td> {{ $fdebittransaction->name }} </td>
    <td> @convert($fdebittransaction->amount_iqd) </td>
    <td> @convert($fdebittransaction->amount_usd) </td>
    <td> {{ $fdebittransaction->exchange_rate }} </td>
    <td> {{ $fdebittransaction->notes }} </td>
    <td> {{ $fdebittransaction->date }} </td>    
    @if(config('easy_panel.crud.fdebittransaction.delete') or config('easy_panel.crud.fdebittransaction.update'))
        <td>

            @if(config('easy_panel.crud.fdebittransaction.update'))
                <a href="@route(getRouteName().'.fdebittransaction.update', ['fdebittransaction' => $fdebittransaction->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.fdebittransaction.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('FdebitTransaction') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('FdebitTransaction') ]) }}</p>
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
