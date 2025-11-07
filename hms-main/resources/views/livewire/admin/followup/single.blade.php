<tr x-data="{ modalIsOpen : false }">
    <td> {{ $followup->bp }} </td>
    <td> {{ $followup->pr }} </td>
    <td> {{ $followup->drain }} </td>
    <td> {{ $followup->itake }} </td>
    <td> {{ $followup->spo2 }} </td>
    <td> {{ $followup->Temp }} </td>
    <td> {{ $followup->treatment }} </td>
    <td> {{ $followup->created_at }} </td>
    <td> {{ $followup->user->name }} </td>
    <td> {{ $followup->pat->name }} </td>    
    @if(config('easy_panel.crud.followup.delete') or config('easy_panel.crud.followup.update'))
        <td>

            @if(config('easy_panel.crud.followup.update'))
                <a href="@route(getRouteName().'.followup.update', ['followup' => $followup->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.followup.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('FollowUp') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('FollowUp') ]) }}</p>
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
