<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Patient')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Patient')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                       @if(Auth::user()->user_type  == "lab" || Auth::user()->user_type  == "superadmin")
                        @if(config('easy_panel.crud.patient.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.lab.patcreate')" class="btn btn-success">مريض جديد</a>
                        </div>
                        @endif
                        @endif
                        @if(config('easy_panel.crud.patient.search'))
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

                        
                        
                       
                        <div class="col-12 card table-responsive" wire:poll.7000ms>
                            <table class="table table-hover">
                            <tr>
                                  
                                    <th>رقم المريض</th>
                                    <th>الأسم</th>
                                    <th></th>
                                </tr>
                              
                                @foreach($patients as $item)
                                <tr>
                                    <td>{{$item->Patient->id ??""}}</td>
                                    <td>{{$item->Patient->name ??""}}</td>

                                    <td>
                                        
                                        <button class = "btn btn-danger" wire:click="hide({{$item->id}})">حذف</button>
                                        <a class="btn btn-default" href="@route(getRouteName().'.lab.patedit', ['redirect' => $item->id])"><i class="fa fa-edit"></i></a>
                                
                                </td>
                                    
                    
                    
                    
                                </tr>
                                @endforeach
                            </table>
                        </div>


                    </div>
                </div>
            </div>

           

        </div>
    </div>
</div>
