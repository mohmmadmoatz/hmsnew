<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">تم تحويلهم الى قسم السونار</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')"
                                class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">محولين الى قسم السونار</li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                            wire:model.lazy="search" @else wire:model="search" @endif placeholder="{{ __('Search') }}"
                            value="{{ request('search') }}">
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

    @if($data->count())

    <div class="col-md-12"
        style="height: 423px;background: #16a085;text-align: center;display: flex;flex-direction: column;/* align-content: flex-end; */justify-content: center;color: white;margin: 10px;/* font-size: 68px; */">
        <h1 style="
    font-size: 68px;
">{{$data[0]->Patient->name}}</h1>
        <hr>
        <h1>المريض الحالي</h1>
    </div>
    @endif

    <button class="btn btn-danger" wire:click="allDone">اكتمل الكل</button>

    <div class="col-12 card table-responsive" wire:poll.7000ms> 
        <table class="table table-hover">
            <tr>
                <th>رقم الوصل</th>
                <th>رقم المريض</th>
                <th>الأسم</th>
                <th></th>
            </tr>

            @foreach($data as $item)
            <tr>
                <td>{{$item->wasl_number}}</td>
                <td>{{$item->Patient->id ??""}}</td>
                <td>{{$item->Patient->name ??""}}</td>

                <td>

                    <a href="#hide" wire:click="hidePat({{$item->id}})">اكتمل</a>

                    <!-- <a
                        href="@route(getRouteName().'.sonar.create')?patient_id={{$item->Patient->id}}&payment_id={{$item->id}}">
                        انشاء سونار</a> -->
                </td>


            </tr>
            @endforeach
        </table>
    </div>