

<div wire:poll.7000ms >

@if(Auth::user()->user_type  == "investor")

<h3>مرحبا بكم في نظام مستشفى صحة المرأة</h3>

<hr>

@livewire("admin.statement.home")


@endif

@if(Auth::user()->user_type  == "superadmin" || Auth::user()->user_type  == "info" || Auth::user()->user_type  == "accountant")
<div class="card-group">
 <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">@convert(App\Models\Patient::count())</h2>
                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">المرضى</h6>
                                </div>
                                <div class="mr-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class ="fa fa-users fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">@convert(App\Models\User::count())</h2>
                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">المستخدمين</h6>
                                </div>
                                <div class="mr-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class ="fa fa-users fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">@convert(App\Models\WarehouseItem::count())</h2>
                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">مواد مخزن</h6>
                                </div>
                                <div class="mr-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class ="fa fa-box fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">@convert(App\Models\Payments::count())</h2>
                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">السندات المالية</h6>
                                </div>
                                <div class="mr-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class ="fa fa-dollar-sign fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

</div>
@endif

@if(Auth::user()->user_type  == "accountant")
<div align="center">
    <img src="{{asset('formimages/hmslogo.png')}}" width="50%">

</div>
@endif

@if(Auth::user()->user_type  == "superadmin" || Auth::user()->user_type  == "info" ||  Auth::user()->user_type  == "tabq")
<div class="row">
<div class="col-md-12">
                            <div class="input-group">
                                <select class="form-control" wire:model.lazy="floorid">
                                    <option value="">اختيار الطابق</option>
                                    <option value="2">الطابق الثاني</option>
                                    <option value="3">الطابق الثالث</option>
                                </select>
                            </div>
                        </div>
                        
</div>

<div class="card-body ">
              

                    <div class="row">
                    @foreach($rooms as $room)
                    <div class="col-md-2  py-2" x-data="{'open':false,modalIsOpen:false}">
                      
                        <button wire:click="check({{$room->id}})" @click="open=!open" class="btn @if($room->user->name ?? '') @if(!$room->checked) btn-warning @else btn-info @endif @else btn-secondary @endif btn-block">
                           
                          

                             {{$room->name}}
                            <hr>
                            الطابق : {{$room->floor}}
                     
                            @if($room->user->name ??"")  
                            <hr x-show="open">  
                            <a x-show="open" class="btn btn-info" href="@route(getRouteName().'.patient.update', ['patient' => $room->user->id])" target="_blank" rel="noopener noreferrer">{{$room->user->name}}</a>
                            <br>
                            <span x-show="open">{{$room->user->doctor->name ??""}}</span>
                            <br>
                            <span x-show="open">{{$room->user->operation->name ??""}}</span>
                            @endif
                            @if($room->user->name ?? '') 
                            @if(Auth::user()->user_type  == "tabq")
                            <button @click.prevent="modalIsOpen = true" class="btn btn-primary mt-1">
                            اخراج المريض
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">هل انت متأكد ؟ </h5>
                        <p>اخراج المريض من الغرفة </p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="outPat({{$room->id}})"  class="text-white btn btn-success shadow">نعم</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">لا</a>
                        </div>
                    </div>
                </div>

                            @endif
                            @if(Auth::user()->user_type  == "tabq")
                            <a href="@route(getRouteName().'.followup.read')?patient_id={{$room->user->id}}" class="btn btn-warning" >ملاحظات المريض</a>
                            @endif

                           

                            @endif

                            @if($room->user->name ??"")  
                            @php
                            $nt_at = $room->nt_at;

                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $nt_at);
                            @endphp
                            @if($date >= new DateTime('today'))
                            <button style="font-size: 13px;" class="btn btn-warning" wire:click="checknt({{$room->id}})"><i class="fa fa-bell"></i>يرجى تهئية المريض</button>
                           
                            @endif
                            @endif

                        </button>
                    </div>
                    @endforeach
                    </div>
                   
                
            </div>
            
@endif




</div>