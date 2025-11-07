<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">الحسابات</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')"
                                class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">المرضى الداخلين</li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                            wire:model.lazy="search" @else wire:model="search" @endif
                            placeholder="{{ __('Search') }}" value="{{ request('search') }}">
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

    <div class="col-12 card table-responsive" wire:poll.7000ms>
        <table class="table table-hover" >
            <tr>
                <th>رقم المريض</th>
                <th>الأسم</th>

                <th>التوجيه</th>
                <th>المبلغ</th>
                <th></th>
            </tr>
            @php

            $setting = App\Models\Setting::first();
            @endphp
            @foreach($data as $item)
            @if(!$item->Patient)
            @continue
            @else
            <tr wire:key="{{$item->Patient->id ?? ''}}" x-data="{ receptModal : false ,tabla:@entangle('tabla').defer,income:@entangle('income').defer,wasl_number:@entangle('wasl_number').defer,description:@entangle('description').defer,amount_iqd:@entangle('amount_iqd').defer,amount_usd:@entangle('amount_usd').defer}">
                <td>{{$item->Patient->id ??""}}</td>
                <td>{{$item->Patient->name ?? ""}}</td>

                @if($item->redirect_id != 5)

               
                <td>{{$item->stage->name ?? ""}}</td>
                @if($item->redirect_id ==2 || $item->redirect_id == 8)
                <td>@convert($item->total_lab) د.ع</td>
                @else
                <td>@convert($item->stage->total_price) د.ع</td>

                @endif

                @endif

              

                @if($item->redirect_id == 5)
                <td>{{$item->Patient->operation->name ?? ""}}</td>
                <td>{{($item->Patient->operation->price ?? 0) + $setting->pat_profile}} د.ع</td>
                @endif
                        <td>

                        @if($item->redirect_id !=5)

                        @if($item->redirect_id ==2 || $item->redirect_id ==8)

                        <a  href="@route(getRouteName().'.payments.create')?payment_type=2&amount_iqd={{$item->total_lab}}&account_type=2&account_id={{$item->Patient->id}}&redirect={{$item->stage->id}}&redirect_doctor_id={{$item->redirect_doctor_id}}&rid={{$item->id}}">قبض 
                        @convert($item->total_lab) د.ع
                        من المريض
                        </a>
                        @if($item->lab)
                        <table x-show="showlab" class="table table-bordered">
                            <tr>
                                <th>الفحص</th>
                                <th>السعر</th>
                            </tr>
                            
                            @foreach(json_decode($item->lab) as $x)
                            <tr>
                                <td>
                                    {{$x->name}}
                                </td>
                                <td>
                                {{$x->amount}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @endif

                        @else
                        <a  href="@route(getRouteName().'.payments.create')?payment_type=2&amount_iqd={{$item->stage->total_price}}&account_type=2&account_id={{$item->Patient->id}}&redirect={{$item->stage->id}}&redirect_doctor_id={{$item->redirect_doctor_id}}&rid={{$item->id}}">قبض 
                        @convert($item->stage->total_price) د.ع
                        من المريض
                        </a>
                        @endif

                        @elseif($item->redirect_id == 5)
                            @php
                            
                        

                            $doctor_amount = ($item->Patient->operation->price ?? 0) * ($item->Patient->hms_nsba / 100);
                            $hms_amount = ($item->Patient->operation->price ??0) - $doctor_amount;
                            $helperdoctor = $setting->helper_doctor;
                            $m5dr_doctor = $setting->m5dr_doctor;
                            $helper_m5dr_doctor = $setting->helper_m5dr_doctor;


                            if(!$item->Patient->operation){
                                continue;
                            }

                            @endphp

                            @if($item->Patient->operation->name =="ولادة طبيعية")
                            <button class="btn btn-danger" wire:click="loadNumberRecept()" @click.prevent='receptModal=true;tabla=1000;income={{$item->Patient->operation->price}};description="{{$item->Patient->operation->name}}";amount_iqd=income + tabla;amount_usd=0;'>
                                
                            قبض : @convert(($item->Patient->operation->price ?? 0) + $setting->pat_profile) د.ع 
                            من المريض 
                            </button>
                            @else
                            <button class="btn btn-danger" wire:click="loadNumberRecept()" @click.prevent='receptModal=true;tabla={{$setting->pat_profile}};income={{$item->Patient->operation->price}};description="{{$item->Patient->operation->name}}";amount_iqd=income + tabla;amount_usd=0;'>
                            قبض : @convert(($item->Patient->operation->price ?? 0)  + $setting->pat_profile) د.ع 
                            من المريض 
                            </button>
                           @endif

                   

                           

                            <!-- صرف : @convert($doctor_amount) د.ع 
                            الى {{$item->doctor->name ?? ""}}
                            <hr>
                            صرف : @convert($helperdoctor) د.ع 
                            الى مساعد الجراح

                            <hr>
                            صرف : @convert($m5dr_doctor) د.ع 
                            الى المخدر

                            <hr>
                            صرف : @convert($helper_m5dr_doctor) د.ع 
                            الى مساعد المخدر -->

  

                <div x-show="receptModal" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="receptModal = false" >
                        <h5 class="pb-2 border-bottom">سند قبض</h5>
                        <div class="row">
                        <div class="col-md-12">
                                <label>التاريخ</label>
                                <input type="date" class="form-control" wire:model.lazy="date">
                            </div>
                            <div class="col-md-6">
                                <label>رقم الوصل</label>
                                <input type="text" class="form-control" x-model="wasl_number">
                            </div>
                            <div class="col-md-6">
                                <label>اسم الجراح</label>
                                <input type="text" class="form-control" readonly value="{{$item->Patient->doctor->name ?? ''}}">
                            </div>
                           
                            <div class="col-md-6">
                                <label>
                                    فتح طبلة
                                </label>
                               <input  type="text" class="form-control" x-model="tabla" x-on:change = "amount_iqd = income *1 + tabla * 1">
                           </div>

                           <div class="col-md-6">
                            <label>
                                مبلغ العملية
                            </label>
                           <input  type="text" class="form-control" x-model="income" x-on:change = "amount_iqd = income *1 + tabla * 1">
                       </div>

                           

                           <div class="col-md-6">
                            <label>دينار</label>
                           <input  type="text" class="form-control"  x-model="amount_iqd">
                       </div>

                       <div class="col-md-6">
                        <label>دولار</label>
                       <input  type="text" class="form-control"  x-model="amount_usd">
                   </div>

                   <div class="col-md-12">
                       <label for="">وذلك عن</label>
                       <textarea class="form-control" x-model="description"></textarea>
                   </div>

                        </div>
                        <div class="mt-5 d-flex justify-content-between">
                           @if($item->Patient->operation->name !="ولادة طبيعية")
                            <a  @click.prevent="receptModal = false"  wire:click.prevent ="saveOpSand({{$income}},{{$doctor_amount}},{{$helperdoctor}},{{$m5dr_doctor}},{{$helper_m5dr_doctor}},{{$item->Patient->id}},0,{{$item->id}})" class="text-white btn btn-success shadow" >{{ __('قبض') }}</a>
                            <a  @click.prevent="receptModal = false" wire:click.prevent ="saveOpSand({{$income}},{{$doctor_amount}},{{$helperdoctor}},{{$m5dr_doctor}},{{$helper_m5dr_doctor}},{{$item->Patient->id}},1,{{$item->id}})" class="text-white btn btn-primary btn-block shadow">{{ __('قبض وطباعة') }}</a>
                            @else
                            <a  @click.prevent="receptModal = false"  wire:click.prevent ="saveOpSand({{$income}},{{$doctor_amount}},0,0,0,{{$item->Patient->id}},0,{{$item->id}})" class="text-white btn btn-success shadow" >{{ __('قبض') }}</a>
                            <a  @click.prevent="receptModal = false" wire:click.prevent ="saveOpSand({{$income}},{{$doctor_amount}},0,0,0,{{$item->Patient->id}},1,{{$item->id}})" class="text-white btn btn-primary btn-block shadow">{{ __('قبض وطباعة') }}</a>
                            @endif
                            <a  @click.prevent="receptModal = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>

                        </div>
                    </div>
                </div>

                        @endif

                      
                      
                     
                        

                      
                        
                        </td>


            </tr>
            @endif
            @endforeach
        </table>

        <div class="m-auto pt-3 pr-3">
                {{ $data->appends(request()->query())->links() }}
            </div>
    </div>