<tr x-data="{ modalIsOpen : false }">
    <td> {{ $warehouse->supplier_name }} </td>
    <td> {{ $warehouse->date }} </td>
    <td> 
    <a target="blank" href="{{asset('storage/'.$warehouse->image)}}">
    {{ $warehouse->menu_no }} </a>
    
    </td>
    <td style="color:green;font-weight:bold"> @convert($warehouse->total) </td>
    <td> {{ $warehouse->address }} </td>
    <td> {{ $warehouse->phone }} </td>
    <td> {{ $warehouse->user->name }} </td>    
    @if(config('easy_panel.crud.warehouse.delete') or config('easy_panel.crud.warehouse.update'))
        <td>
        @if( Auth::user()->user_type  == "stockmanagment" ||  Auth::user()->user_type  == "superadmin" )
            @if(config('easy_panel.crud.warehouse.update'))
                <a href="@route(getRouteName().'.warehouse.update', ['warehouse' => $warehouse->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif
            @endif
            @if( Auth::user()->user_type  == "stockmanagment" ||  Auth::user()->user_type  == "superadmin" )
            @if(config('easy_panel.crud.warehouse.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Warehouse') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Warehouse') ]) }}</p>
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
