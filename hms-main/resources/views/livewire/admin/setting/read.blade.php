<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">الأسعار</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">الأسعار</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(config('easy_panel.crud.setting.create'))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.setting.create')" class="btn btn-success">{{ __('CreateTitle', ['name' => __('Setting') ]) }}</a>
                        </div>
                        @endif
                        @if(config('easy_panel.crud.setting.search'))
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
                        <td style='cursor: pointer' wire:click="sort('xray')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'xray') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'xray') fa-sort-amount-up ml-2 @endif'></i> الأشعة</td>
                        <td style='cursor: pointer' wire:click="sort('sonar')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'sonar') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'sonar') fa-sort-amount-up ml-2 @endif'></i> السونار </td>
                        <td style='cursor: pointer' wire:click="sort('clinic_price')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'clinic_price') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'clinic_price') fa-sort-amount-up ml-2 @endif'></i>  العيادة الأستشارية </td>
                        <td>العملية</td>
                        
                        @if(config('easy_panel.crud.setting.delete') or config('easy_panel.crud.setting.update'))
                        <td>{{ __('Action') }}</td>
                        @endif
                    </tr>

                    @foreach($settings as $setting)
                        @livewire('admin.setting.single', ['setting' => $setting], key($setting->id))
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $settings->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
