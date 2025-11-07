<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Lab')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Lab')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.lab.create'))
                        <div class="col-md-6" >
             
                        @if($patient_id) 
                       <label for='name' class='control-label'> {{ __('المريض') }}</label>
                        <input readonly @if($patient_id) disabled @endif  type='text' value="{{App\Models\Patient::find($patient_id)->name}}"
                            class="form-control @error('name') is-invalid @enderror" id='name'>
                            <a href="#cancel" wire:click="clear()" class="btn btn-danger">الغاء</a>
                        @error('phone') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                        @else
                        @include('livewire.admin.widget.selectpat',['model'=>"searchpat"])

                        @endif  
                            
                        </div>
                        @endif
                        @if(config('easy_panel.crud.lab.search'))
                        <div class="col-md-3">
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
                        <div class="col-md-2">
                            <a href="{{ route('admin.lab.statistics') }}" class="btn btn-info btn-block">
                                <i class="fas fa-chart-bar"></i> {{ __('احصائيات المختبر') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td> {{ __('Patient Name') }} </td>
                        <td> الفحوصات </td>
                        <td style='cursor: pointer' wire:click="sort('notes')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'notes') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'notes') fa-sort-amount-up ml-2 @endif'></i> {{ __('Notes') }} </td>
                        <td style='cursor: pointer' wire:click="sort('created_at')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'created_at') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'created_at') fa-sort-amount-up ml-2 @endif'></i> التاريخ </td>
                        
                        @if(config('easy_panel.crud.rays.delete') or config('easy_panel.crud.rays.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($labs as $lab)
                        @livewire('admin.lab.single', ['lab' => $lab], key($lab->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $labs->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
