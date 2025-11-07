<tr x-data="{ modalIsOpen : false ,modalIsOpendoctor:false,modalIsOpendoctor2:false,modalIsOpendoctor3:false,m5drisopen:false,m5drisopen2:false,modalIsOpendoctor4:false,supervised:false,mqema:false,modalIsOpenNurse:false,modalIsOpenAmb:false,convertModal:false,outexpmodal:false}">
    <td> 
        {{ $loop }} 

        <hr>
        @if(!$operationhold->hasPostpond)
        <a href="@route(getRouteName().'.opostpond.create')?operationhold_id={{$operationhold->id}}" target="_blank" >تأجيل العملية</a>
        @else
        <span class="badge badge-danger">
        العملية مؤجلة الى : 
        {{$operationhold->haspostpond->date}}
        </span>
        
        @endif

    </td>
    <td> {{ $operationhold->payment_number}} </td>
    <td> {{ $operationhold->Patient->name ??"" }} </td>
    <td> {{ $operationhold->doctor->name ?? "" }} </td>
    <td> @convert( $operationhold->operation_price) </td>
    
    <td> 
    @if($operationhold->operation_name == "ولادة طبيعية")
    <button class="btn btn-info" x-on:click = "convertModal=true">ولادة طبيعية (تحويل الى قيصرية )</button>

    <div x-show="convertModal" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="convertModal = false" >
            <h5 class="pb-2 border-bottom">تحويل الى قيصرية</h5>
            
                <p>هل انت متأكد من تحويل العملية الى عملية قيصرية ؟ </p>
            

                <label for="">سعر العملية</label>
                <input type="text" class="form-control" wire:model.lazy="income">

                سوف يتم انشاء وصل قبض جديد بقيمة
                <span class="text-primary">@convert($income -  $operationhold->operation_price )</span>

            <div class="mt-5 d-flex justify-content-between">
                <a  @click.prevent="convertModal = false;" wire:click.prevent="convertToQ({{$operationhold->id}})" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="convertModal = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>

    @else
        {{$operationhold->operation_name}} 
        @endif
    </td>

    <td>
    
    @if(!$operationhold->ware_id)
    0
    @else
    <a  target="_blank" href="@route(getRouteName().'.warehouseexport.update', ['warehouseexport' => $operationhold->ware_id])" class="btn btn-warning">@convert($operationhold->outexp ?? 0)</a>
    @endif
    


    </td>

    <td> 
        @if(!$operationhold->doctor_paid)
        @if($operationhold->operation_name != "ولادة طبيعية" || $operationhold->supervised)
       <button  wire:click="$set('doctorexp',{{$operationhold->doctorexp}})" x-on:click="modalIsOpendoctor = true;" class="btn btn-danger">@convert($operationhold->doctorexp ?? 0)</button> 

       <div x-show="modalIsOpendoctor" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="modalIsOpendoctor = false" >
            <h5 class="pb-2 border-bottom">تعديل السعر</h5>
            <p>النسبة : {{$operationhold->nsba}}</p>
            <label>تغيير النسبة</label>
            <select class="form-control" wire:change="updateNsba($event.target.value)">
            <option @if($operationhold->nsba == 0) selected @endif value="0">0%</option>
            <option @if($operationhold->nsba == 60) selected @endif value="60">60%</option>
            <option @if($operationhold->nsba == 62) selected @endif value="62">62%</option>
            <option @if($operationhold->nsba == 65) selected @endif value="65">65%</option>
            <option @if($operationhold->nsba == 68) selected @endif value="68">68%</option>
            <option @if($operationhold->nsba == 70) selected @endif  value="70">70%</option>
            <option @if($operationhold->nsba == 75) selected @endif  value="75">75%</option>
            <option @if($operationhold->nsba == 80) selected @endif  value="80">80%</option>
            </select>

            <p>
             السعر الحالي
            </p>
            <input type="text" class="form-control" wire:model.lazy="doctorexp">
            <div class="mt-5 d-flex justify-content-between">
                <a  @click.prevent="modalIsOpendoctor = false;" wire:click.prevent="savedoctor()" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="modalIsOpendoctor = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
    @else
    <button  @click.prevent="supervised = true" class="btn btn-danger">مشرفة ام لا ؟</button> 

<div x-show="supervised" class="cs-modal animate__animated animate__fadeIn">
 <div class="bg-white shadow rounded p-5" @click.away="supervised = false" >
     <h5 class="pb-2 border-bottom">تحديد اجور الطبيب</h5>
     <p>
               يرجى التحديد
            </p>
            <hr>
            <select wire:model="supervisedPrice" class="form-control">
                <option value="">مشرفة ام لا</option>
                <option value="{{$settings->supervised}},1">مشرفة</option>

                @if($operationhold->nsba ==60)
                <option value="{{$settings->not_supervised}},2">لا</option>
                @else
                <option value="0,2">لا</option>

                @endif

               
            </select>
     <div class="mt-5 d-flex justify-content-between">
         <a wire:click.prevent="savedoctor('{{$supervisedPrice}}')" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
         <a @click.prevent="supervised = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
     </div>
 </div>
</div>
    @endif

       @else
   
       @convert($operationhold->doctorexp)
        @endif
    </td>
    
    <td> 
        @if(!$operationhold->helper_paid && $operationhold->helper!=0 )
       <button wire:click="$set('helperprice',{{$operationhold->helper}})"   @click.prevent="modalIsOpendoctor2 = true" class="btn btn-danger">@convert($operationhold->helper)</button> 
       <div x-show="modalIsOpendoctor2" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="modalIsOpendoctor2 = false" >
            <h5 class="pb-2 border-bottom">تعديل السعر</h5>
            <p>
             السعر الحالي
            </p>
            <input type="text" class="form-control" wire:model.lazy="helperprice">

            <div class="mt-5 d-flex justify-content-between">
                <a @click.prevent="modalIsOpendoctor2 = false" wire:click.prevent="savehelper" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="modalIsOpendoctor2 = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
       @else
   
       @convert($operationhold->helper)
        @endif
    </td>

    <td> 
        @if(!$operationhold->m5dr_selected && $operationhold->m5dr !=0)
       <button  @click.prevent="m5drisopen = true" class="btn btn-danger"> نوع العملية</button> 
       <div x-show="m5drisopen" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="m5drisopen = false" >
            <h5 class="pb-2 border-bottom">انشاء سند صرف</h5>
            <p>
               يرجى تحديد نوع العملية
            </p>
            <hr>
            <select wire:model="optype" class="form-control">
                <option value="">نوع العملية</option>
                <option value="{{$settings->m5dr_doctor}}">عملية فوق الكبرى</option>
                <option value="{{$settings->m5dr_large_doctor}}">عملية  الكبرى</option>
                <option value="{{$settings->m5dr_small_doctor}}">عملية وسطى او صغرى</option>
                <option value="0.07">7%</option>
                <option value="0.06">6%</option>
                <option value="0.05">5%</option>
            </select>

            
            @if($optype)
            @if($optype == "0.07" || $optype == "0.06" || $optype == "0.05")
            <label for="">مبلغ العملية</label>
            <input type="text" class="form-control" readonly value="@convert($operationhold->operation_price)">
            <hr>
            <label for="">نسبة المخدر</label>
            <input type="text" class="form-control" readonly value="@convert($operationhold->operation_price * $optype)">
            @else
            <label for="">نسبة المخدر</label>
            <input type="text" class="form-control" wire:model.lazy="optype">
            @endif

            @endif

            <div class="mt-5 d-flex justify-content-between">
                <a wire:click.prevent="savem5dr({{$optype}})" class="text-white btn btn-success shadow">{{ __('انشاء السند') }}</a>
                <a @click.prevent="m5drisopen = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
       @else
        
       

        @if(!$operationhold->m5dr_paid && $operationhold->m5dr !=0)
        <button  wire:click="$set('m5drprice',{{$operationhold->m5dr}})" @click.prevent="m5drisopen2 = true" class="btn btn-danger">    @convert($operationhold->m5dr)</button> 
        
        <div x-show="m5drisopen2" class="cs-modal animate__animated animate__fadeIn">
            <div class="bg-white shadow rounded p-5" @click.away="m5drisopen2 = false" >
                <h5 class="pb-2 border-bottom">تعديل السعر</h5>
                <p>
                 السعر الحالي
                </p>
                <input type="text" class="form-control" wire:model.lazy="m5drprice">
    
                <div class="mt-5 d-flex justify-content-between">
                    <a @click.prevent="m5drisopen2 = false" wire:click.prevent="savem5dr2" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                    <a @click.prevent="m5drisopen2 = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
                </div>
            </div>
        </div>

        @else
        @convert($operationhold->m5dr)
        @endif

        
        @endif
    </td>
    
    <td> 
        @if(!$operationhold->helperm5dr_paid && $operationhold->helperm5dr !=0)
       <button wire:click="$set('helperm5dr',{{$operationhold->helperm5dr}})"  @click.prevent="modalIsOpendoctor3 = true" class="btn btn-danger">@convert($operationhold->helperm5dr)</button> 
       <div x-show="modalIsOpendoctor3" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="modalIsOpendoctor3 = false" >
            <h5 class="pb-2 border-bottom">تعديل السعر</h5>
            <p>
             السعر الحالي
            </p>
            <input type="text" class="form-control" wire:model.lazy="helperm5dr">

            <div class="mt-5 d-flex justify-content-between">
                <a @click.prevent="modalIsOpendoctor3 = false" wire:click.prevent="savehelperm5dr" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="modalIsOpendoctor3 = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
       @else
   
       @convert($operationhold->helperm5dr)
        @endif
    </td>

    <td> 
        @if(!$operationhold->qabla_paid && $operationhold->operation_name =="ولادة طبيعية")
       <button  wire:click="$set('qabla',{{$operationhold->qabla}})" @click.prevent="modalIsOpendoctor4 = true" class="btn btn-danger">@convert($operationhold->qabla)</button> 
       <div x-show="modalIsOpendoctor4" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="modalIsOpendoctor4 = false" >
            <h5 class="pb-2 border-bottom">تعديل السعر</h5>
            <p>
             السعر الحالي
            </p>
            <input type="text" class="form-control" wire:model.lazy="qabla">
            <div class="mt-5 d-flex justify-content-between">
                <a wire:click.prevent="saveqabla" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="modalIsOpendoctor4 = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
       @else
   
       @if($operationhold->operation_name =="ولادة طبيعية")
       @convert($settings->qabla)
       @else
       0
       @endif
     
        @endif
    </td>

    <td> 
        @if(!$operationhold->mqema_paid && $operationhold->operation_name =="ولادة طبيعية" && $operationhold->supervised == 2)
       <button wire:click="fillmqema" @click.prevent="mqema = true" class="btn btn-danger">@convert($operationhold->mqema_price)
        /
        {{$operationhold->mqema->name ??""}}
        <a wire:loading wire:target="savemqema"><i class="fas fa-spinner fa-spin" ></i></a>
       </button> 
       <div x-show="mqema" class="cs-modal animate__animated animate__fadeIn">
        <div class="bg-white shadow rounded p-5" @click.away="mqema = false" >
            <h5 class="pb-2 border-bottom">تعديل السعر</h5>
            <p>
             السعر الحالي
            </p>
            <input type="text" class="form-control" wire:model.lazy="mqema_price">

            <p>
                الطبيب
               </p>
               
               <div wire:ignore>
  
               <select class="form-control selectpicker2" data-live-search="true" wire:model="mqema_id">
                                      <option value="">يرجى اختيار طبيب</option>
                                      @foreach(App\Models\User::Where("user_type","resident")->get() as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                                  </select>
  
               </div>


            <div class="mt-5 d-flex justify-content-between">
                <a wire:click.prevent="savemqema" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                <a @click.prevent="mqema = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
            </div>
        </div>
    </div>
       @else
   
       @if($operationhold->operation_name =="ولادة طبيعية" && $operationhold->supervised ==2)
       @convert($operationhold->mqema_price)
       @else
       0
       @endif
     
        @endif
    </td>

    <td>
        @if(!$operationhold->nurse_paid)
        <button wire:click="$set('nurse_price',{{$operationhold->nurse_price}})"   @click.prevent="modalIsOpenNurse = true" class="btn btn-danger">@convert($operationhold->nurse_price)</button> 
        <div x-show="modalIsOpenNurse" class="cs-modal animate__animated animate__fadeIn">
         <div class="bg-white shadow rounded p-5" @click.away="modalIsOpenNurse = false" >
             <h5 class="pb-2 border-bottom">تعديل السعر</h5>
             <p>
              السعر الحالي
             </p>
             <input type="text" class="form-control" wire:model.lazy="nurse_price">
        
             <div class="mt-5 d-flex justify-content-between">
                 <a @click.prevent="modalIsOpenNurse = false" wire:click.prevent="savenurse" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                 <a @click.prevent="modalIsOpenNurse = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
             </div>
         </div>
        </div>
        @else
        @convert($operationhold->nurse_price)
        @endif
    </td>

    
    <td>
        @if(!$operationhold->ambulance_paid)

        <button wire:click="fillamb"   @click.prevent="modalIsOpenAmb = true;$('.selectpicker2').selectpicker();" class="btn btn-danger">
            
        @convert($operationhold->ambulance)
    /
        {{$operationhold->ambdoctor->name ??""}}

        <a wire:loading wire:target="saveAmb"><i class="fas fa-spinner fa-spin" ></i></a>

        </button> 
        <div x-show="modalIsOpenAmb" class="cs-modal animate__animated animate__fadeIn">
         <div class="bg-white shadow rounded p-5" @click.away="modalIsOpenAmb = false" >



             <h5 class="pb-2 border-bottom">تعديل السعر</h5>

             <p>
              السعر الحالي
             </p>
             <input type="text" class="form-control" wire:model.lazy="ambulance">

             <p>
              الطبيب
             </p>
             
             <div wire:ignore>

             <select class="form-control selectpicker2" data-live-search="true" wire:model="ambulance_doctor">
                                    <option value="">يرجى اختيار طبيب</option>
                                    @foreach($doctors_res as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                                </select>

             </div>
            
        
             <div class="mt-5 d-flex justify-content-between">
                 <a @click.prevent="modalIsOpenAmb = false" wire:click.prevent="saveAmb" class="text-white btn btn-success shadow">{{ __('موافق') }}</a>
                 <a @click.prevent="modalIsOpenAmb = false" class="text-white btn btn-danger shadow">{{ __('الغاء') }}</a>
             </div>
         </div>
        </div>

        @else
        @convert($operationhold->ambulance)
        @endif
    </td>

    @if(config('easy_panel.crud.operationhold.delete') or config('easy_panel.crud.operationhold.update'))
        <td>

            @if(config('easy_panel.crud.operationhold.update'))
                <a href="@route(getRouteName().'.operationhold.update', ['operationhold' => $operationhold->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.operationhold.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('OperationHold') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('OperationHold') ]) }}</p>
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
