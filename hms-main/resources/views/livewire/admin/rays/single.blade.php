<tr x-data="{ modalIsOpen : false }">
    <td> {{ $rays->patient->name ?? "" }} </td>
    <td><a target="blank" href="{{asset('storage/'.$rays->image)}}">
    فتح الصورة</a></td>
    <td> {{ $rays->notes }} </td>    
    <td> {{ $rays->created_at }} </td>    
    @if(config('easy_panel.crud.rays.delete') or config('easy_panel.crud.rays.update'))
        <td>

            @if(config('easy_panel.crud.rays.update'))
                <a href="@route(getRouteName().'.rays.update', ['rays' => $rays->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.rays.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Rays') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Rays') ]) }}</p>
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
