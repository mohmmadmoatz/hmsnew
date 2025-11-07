<tr x-data="{ modalIsOpen : false }">
    <td> 

    @if(Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "superadmin" )
        اجور الأشعة :
        @convert($setting->xray) 
        <hr>
        اجور الطبيب
        @convert($setting->xray_doctor_price) 
        <hr>
        @endif                  
        الطبيب :
        {{$setting->xdoctor->name  ?? "لم يتم تعيين"}}


    </td>
    <td> 
    @if(Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "superadmin" )
    اجور السونار :
        @convert($setting->sonar) 
        <hr>
        اجور الطبيب
        @convert($setting->doctor_sonar_price) 
        <hr>
        @endif
        الطبيب :
        {{$setting->sdoctor->name  ?? "لم يتم تعيين"}}

    </td>
    <td>
    @if(Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "superadmin" )
         اجور العيادة
       :  @convert($setting->clinic_price) 
        <hr>
        اجور الطبيب 
       : @convert($setting->doctor_price)
       <hr>
       @endif
    
       {{$setting->doctor->name  ?? "لم يتم تعيين"}}
    </td>
    
    <td>
    @if(Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "superadmin" )
    اجور الطبلة
       :  @convert($setting->pat_profile) 
        <hr>

        اجور مساعد الجراح
        :   @convert($setting->helper_doctor) 
        <hr>

        اجور المخدر
        :   @convert($setting->m5dr_doctor) 
        <hr>

        اجور مساعد المخدر
        :   @convert($setting->helper_m5dr_doctor) 
  @endif
    </td>
     
    @if(config('easy_panel.crud.setting.delete') or config('easy_panel.crud.setting.update'))
        <td>

            @if(config('easy_panel.crud.setting.update'))
                <a href="@route(getRouteName().'.setting.update', ['setting' => $setting->id])" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(config('easy_panel.crud.setting.delete'))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Setting') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Setting') ]) }}</p>
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
