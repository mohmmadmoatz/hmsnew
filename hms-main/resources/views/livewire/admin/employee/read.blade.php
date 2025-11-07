<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Employee')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Employee')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.employee.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.employee.create')" class="btn btn-success">{{ __('CreateTitle', ['name' => __('Employee') ]) }}</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.employee.search'))
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode')) wire:model.lazy="search" @else wire:model="search" @endif placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td style='cursor: pointer' wire:click="sort('name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Name') }} </td>
                        <td style='cursor: pointer' wire:click="sort('salary')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'salary') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'salary') fa-sort-amount-up ml-2 @endif'></i> {{ __('Salary') }} </td>
                        <td>القسم</td>
                        <td style='cursor: pointer' wire:click="sort('notes')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'notes') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'notes') fa-sort-amount-up ml-2 @endif'></i> {{ __('Notes') }} </td>

                        
                        @if(config('easy_panel.crud.employee.delete') or config('easy_panel.crud.employee.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($employees as $employee)
                        @livewire('admin.employee.single', ['employee' => $employee], key($employee->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $employees->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
