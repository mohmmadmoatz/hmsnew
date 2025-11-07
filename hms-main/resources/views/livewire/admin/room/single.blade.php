<tr x-data="{ modalIsOpen : false }">
    <td> {{ $room->name }} </td>
    <td> 
      @if($room->user->name ??"")    
      <a href="@route(getRouteName().'.patient.update', ['patient' => $room->user->id])" target="_blank" rel="noopener noreferrer">{{$room->user->name}}</a>
      @else
      لايوجد مريض 
      @endif
     

    </td>
    <td> {{ $room->floor }} </td>

    <td> {{ $room->notes }} </td>    
    @if(config('easy_panel.crud.room.delete') or config('easy_panel.crud.room.update'))
        <td>
        @if(Auth::user()->user_type  == "superadmin")
            @if(config('easy_panel.crud.room.update'))
                <a href="@route(getRouteName().'.room.update', ['room' => $room->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif
            @endif
            @if(Auth::user()->user_type  == "superadmin")
            @if(config('easy_panel.crud.room.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Room') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Room') ]) }}</p>
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
