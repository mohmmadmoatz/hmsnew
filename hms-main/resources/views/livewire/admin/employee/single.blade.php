<tr x-data="{ modalIsOpen : false }">
    <td> {{ $employee->name }} </td>
    <td> @convert($employee->salary)  </td>
    <td> {{ $employee->category->name ?? "" }} </td>    
    <td> {{ $employee->notes }} </td>    
    @if(config('easy_panel.crud.employee.delete') or config('easy_panel.crud.employee.update'))
        <td>

            @if(config('easy_panel.crud.employee.update'))
                <a href="@route(getRouteName().'.employee.update', ['employee' => $employee->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.employee.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Employee') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Employee') ]) }}</p>
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
