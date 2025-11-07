<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">صفحة المريض</h3>

                <div class="px-2 mt-4">
                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">صفحة المريض</li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                            wire:model.lazy="search" @else wire:model="search" @endif
                            placeholder="{{ __('Search by patient name') }}" value="{{ $search }}">
                        <div class="input-group-append">
                            <button class="btn btn-default">
                                <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin"></i></a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 card table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>رقم المريض</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>الحالة</th>
                    <th>حالة الخروج</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr x-data="{ modalIsOpen : false }">
                    <td> {{ $patient->id }} </td>
                    <td> {{ $patient->name }} </td>
                    <td> {{ $patient->phone }} </td>
                    <td> {{ $patient->stage->name ?? ""}} </td>

                    <td>
                        @if($patient->checkout_at)
                        <span class="badge badge-success">تم اخراج المريض من الغرفة :
                            {{$patient->croom->name ?? ""}}
                            في تاريخ
                            {{$patient->checkout_at}}
                        </span>
                        @endif
                    </td>

                    <td>
                        <a target="blank" class="btn btn-outline-info" href="@route('printcard')?id={{$patient->id}}">طباعة الباج</a>

                        @if($patient->status==5)
                        <a target="blank" class="btn btn-outline-info" href="@route('printedForm')?id={{$patient->id}}">طباعة الطبلة</a>
                        <a href="@route('patinfo')?id={{$patient->id}}" target="_blank"><i class="fa fa-print"></i></a>
                        @endif

                        @if(config('easy_panel.crud.patient.update'))
                            <a href="@route(getRouteName().'.patient.update', ['patient' => $patient->id])" class="btn text-primary mt-1">
                                <i class="icon-pencil"></i>
                            </a>
                        @endif

                        @if(Auth::user()->user_type == "info" || Auth::user()->user_type == "superadmin")
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="m-auto pt-3 pr-3">
            {{ $patients->appends(request()->query())->links() }}
        </div>
    </div>
</div>
