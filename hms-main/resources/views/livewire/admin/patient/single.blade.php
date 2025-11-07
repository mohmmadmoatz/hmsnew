<tr x-data="{ modalIsOpen : false }">
    <td> {{ $patient->id }} </td>
    <td> {{ $patient->name }} </td>
    
    <td> {{ $patient->phone }} </td>
    <td> {{ $patient->stage->name  ??""}} </td>    

    <td>
        @if($patient->checkout_at)
        <span class="badge badge-success">تم اخراج المريض من الغرفة  : 
            {{$patient->croom->name ??""}}
            في تاريخ 
            {{$patient->checkout_at}}
        </span>
      
        
        @endif
    </td>

    @if(config('easy_panel.crud.patient.delete') or config('easy_panel.crud.patient.update'))
        <td>

  
            @if(config('easy_panel.crud.patient.update'))
                <a href="@route(getRouteName().'.patient.update', ['patient' => $patient->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif
        
   @if(Auth::user()->user_type  == "info" || Auth::user()->user_type  == "superadmin")
            @if(config('easy_panel.crud.patient.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Patient') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Patient') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it.') }}</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
            @endif

            <a target="blank" class="btn btn-outline-info" href="@route('printcard')?id={{$patient->id}}">طباعة الباج</a>
            

            
            @if($patient->status==5)
            <a target="blank" class="btn btn-outline-info" href="@route('printedForm')?id={{$patient->id}}">طباعة الطبلة</a>
            <a href="@route('patinfo')?id={{$patient->id}}" target="_blank"><i class="fa fa-print"></i></a>
            @endif
          

           
         
        </td>
    @endif
</tr>
