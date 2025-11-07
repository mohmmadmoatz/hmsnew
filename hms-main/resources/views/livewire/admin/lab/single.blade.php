<tr x-data="{ modalIsOpen : false }">
<td> {{ $lab->patient->name ?? "" }} </td>
    <td>
        <a target="blank" href="{{route('labprint')}}?id={{$lab->id}}">
    طباعة الفحص</a>
</td>
    <td> {{ $lab->notes }} </td>    
    <td> {{ $lab->created_at }} </td>    
    @if(config('easy_panel.crud.lab.delete') or config('easy_panel.crud.lab.update'))
        <td>
        @if(Auth::user()->user_type  == "lab" ||  Auth::user()->user_type  == "superadmin" )



            @if(config('easy_panel.crud.lab.update'))
                <a href="@route(getRouteName().'.lab.update', ['lab' => $lab->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.lab.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Lab') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Lab') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it.') }}</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
            @endif
        </td>
    @endif
</tr>
