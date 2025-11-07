<tr x-data="{ modalIsOpen : false }">
    <td> {{ $bank->wasl_number }} </td>
    <td> {{ $bank->date }} </td>
    <td> {{ $bank->description }} </td>
    <td> @convert($bank->amount_iqd) </td>
    <td> @convert($bank->amount_usd) </td>    
    @if(config('easy_panel.crud.bank.delete') or config('easy_panel.crud.bank.update'))
        <td>

            @if(config('easy_panel.crud.bank.update'))
                <a href="@route(getRouteName().'.bank.update', ['bank' => $bank->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.bank.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Bank') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Bank') ]) }}</p>
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
