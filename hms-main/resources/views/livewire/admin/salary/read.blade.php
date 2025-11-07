<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Salary')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Salary')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.salary.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.salary.create')" class="btn btn-success">{{ __('CreateTitle', ['name' => __('Salary') ]) }}</a>
                        </div>
                        @endif
                       
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="month" class="form-control" @if(config('easy_panel.lazy_mode')) wire:model.lazy="month" @else wire:model="search" @endif placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <input type="text" wire:model.lazy="wasl_number" class="form-control" placeholder="رقم الوصل">
                            <button wire:click="payAllSalary()" class="btn btn-info">دفع المحدد ({{count($selected)}})</button>
                        </div>

                   
                       
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" wire:model="selectall">
                        </td>
                      
                            <td>
                                الموظف
                            </td>
                            <td>
                                الراتب
                            </td>
                            <td>
                                السلف
                            </td>
                            <td>
                                الصافي
                            </td>
                            <td>تم دفع الراتب ؟</td>
                      
                    </tr>

                    @foreach($employee as $salary)
                        <tr>
                            <td>
                                <input  @if(count($salary->salaries)) disabled @endif type="checkbox"  value="{{$salary->id}}" wire:model="selected">
                            </td>
                            <td>
                                {{ $salary->name }}
                            </td>
                            <td>
                               @convert($salary->salary)
                            </td>

                            <td>

                                @convert($salary->empadvance->sum("amount") ?? 0)
                            </td>

                            <td>
                                @convert($salary->salary - ($salary->empadvance->sum("amount") ?? 0) )
                            </td>

                            <td>
                            
                                @if(count($salary->salaries))
                                    <span class="badge badge-success">
                                        <i class="fa fa-check"></i>
                                        

                                    </span>
                                    <a wire:click="returnSalary({{$salary->id}})" href="#paysalary">تراجع</a>
                                @else
                                    <span class="badge badge-danger"><i class="fa fa-times"></i></span>
                                   
                                @endif
                                
                            </td>
                           
                        </tr>

                        @endforeach
                  
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $employee->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
