

<li class="nav-small-cap"><span class="hide-menu">
    اخر تحديث للنظام 
    <span class="badge badge-pill badge-success ml-auto"> {{\Carbon\Carbon::parse("26-11-2025 19:00:00")->diffForHumans()}} </span>
</span></li>


<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">قائمة النظام</span></li>
<li class="sidebar-item @isActive(getRouteName().'.home', 'selected')">
    <a class="sidebar-link @isActive(getRouteName().'.home', 'active')" href="@route(getRouteName().'.home')" aria-expanded="false">
        <i data-feather="home" class="feather-icon"></i>
        <span class="hide-menu">{{ __('Home') }}</span>
    </a>
</li> 
@if(Auth::user()->user_type  == "superadmin")
<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i data-feather="{{ get_icon('settings') }}" class="feather-icon"></i>
        <span class="hide-menu">تهيئة النظام</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
        <li class="sidebar-item @isActive(getRouteName().'.'.'room'.'.read')">
            <a href="@route(getRouteName().'.room.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'room'.'.read')">
                <span class="hide-menu"> الغرف </span>
            </a>
        </li>
        <li class="sidebar-item @isActive(getRouteName().'.'.'clinic'.'.read')">
            <a href="@route(getRouteName().'.clinic.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'clinic'.'.read')">
                <span class="hide-menu"> العيادات </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'operation'.'.read')">
            <a href="@route(getRouteName().'.operation.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'operation'.'.read')">
                <span class="hide-menu"> العمليات </span>
            </a>
        </li>

     

        <li class="sidebar-item @isActive(getRouteName().'.'.'setting'.'.read')">
            <a href="@route(getRouteName().'.setting.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'setting'.'.read')">
                <span class="hide-menu"> الأسعار </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'stage'.'.read')">
            <a href="@route(getRouteName().'.stage.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'stage'.'.read')">
                <span class="hide-menu"> التوجيهات </span>
            </a>
        </li>

      
        <li class="sidebar-item @isActive(getRouteName().'.'.'cashaccount'.'.read')">
            <a href="@route(getRouteName().'.cashaccount.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'cashaccount'.'.read')">
                <span class="hide-menu"> الحسابات النقدية </span>
            </a>
        </li>


        <li class="sidebar-item @isActive(getRouteName().'.'.'user'.'.read')">
            <a href="@route(getRouteName().'.user.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'user'.'.read')">
                <span class="hide-menu"> المستخدمين </span>
            </a>
        </li>
        
    </ul>





</li>
@endif

@if(Auth::user()->user_type  == "superadmin" || Auth::user()->user_type  == "accountant")
<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">المحاسبة</span></li>


<li class='sidebar-item'>
@if(Auth::user()->user_type  == "accountant")

<li
    class='sidebar-item @isActive([getRouteName().".cashaccount.read", getRouteName().".cashaccount.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".cashaccount.read", getRouteName().".cashaccount.update"], "active") '
    href="@route(getRouteName().'.cashaccount.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">الحسابات النقدية</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".setting.read", getRouteName().".setting.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".setting.read", getRouteName().".setting.update"], "active") '
    href="@route(getRouteName().'.setting.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">الأسعار</span>
    </a>
</li>
<li
    class='sidebar-item @isActive([getRouteName().".stage.read", getRouteName().".stage.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".stage.read", getRouteName().".stage.update"], "active") '
    href="@route(getRouteName().'.stage.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">التوجيهات</span>
    </a>
</li>
@endif

<li
    class='sidebar-item @isActive([getRouteName().".payments.converted", getRouteName().".payments.converted", getRouteName().".payments.converted"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".payments.converted", getRouteName().".payments.converted", getRouteName().".payments.converted"], "active") '
        href="@route(getRouteName().'.payments.converted')" aria-expanded="false">
        <i data-feather="{{ get_icon("user") }}" class="feather-icon"></i>
        <span class="hide-menu">المرضى الداخلين</span>
    </a>
</li>
<li
    class='sidebar-item @isActive([getRouteName().".payments.patstatement", getRouteName().".payments.patstatement", getRouteName().".payments.patstatement"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".payments.patstatement", getRouteName().".payments.patstatement", getRouteName().".payments.patstatement"], "active") '
        href="@route(getRouteName().'.payments.patstatement')" aria-expanded="false">
        <i data-feather="{{ get_icon("file") }}" class="feather-icon"></i>
        <span class="hide-menu">كشف حساب المرضى</span>
    </a>
</li>
<li
    class='sidebar-item @isActive([getRouteName().".operationhold.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".operationhold.read"], "active") '
        href="@route(getRouteName().'.operationhold.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("file") }}" class="feather-icon"></i>
        <span class="hide-menu">العمليات</span>
    </a>
</li>

<li
class='sidebar-item @isActive([getRouteName().".opostpond.read"], "selected")'>
<a class='sidebar-link @isActive([getRouteName().".opostpond.read"], "active") '
    href="@route(getRouteName().'.opostpond.read')" aria-expanded="false">
    <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
    <span class="hide-menu">العمليات المؤجلة</span>
</a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".payments.read", getRouteName().".payments.create", getRouteName().".payments.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".payments.read", getRouteName().".payments.create", getRouteName().".payments.update"], "active") '
        href="@route(getRouteName().'.payments.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">السندات المالية</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".bank.read", getRouteName().".bank.create", getRouteName().".bank.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".bank.read", getRouteName().".bank.create", getRouteName().".bank.update"], "active") '
        href="@route(getRouteName().'.bank.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">سحوبات الخزنة</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".saveaccount.read", getRouteName().".saveaccount.create", getRouteName().".saveaccount.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".saveaccount.read", getRouteName().".saveaccount.create", getRouteName().".saveaccount.update"], "active") '
        href="@route(getRouteName().'.saveaccount.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">الحساب الاحتياطي</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".statement.home"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".statement.home"], "active") '
        href="@route(getRouteName().'.statement.home')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">الكشوفات</span>
    </a>
</li>

<!-- <li
    class='sidebar-item @isActive([getRouteName().".attendance.logs"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".attendance.logs"], "active") '
        href="@route(getRouteName().'.attendance.logs')" aria-expanded="false">
        <i data-feather="{{ get_icon("login") }}" class="feather-icon"></i>
        <span class="hide-menu">الحظور والأنصراف</span>
    </a>
</li> -->

</li>
@endif


@if(Auth::user()->user_type  == "superadmin" || Auth::user()->user_type  == "accountant")

<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">نظام الموظفين</span></li>

<li
    class='sidebar-item @isActive([getRouteName().".empcategory.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".empcategory.read"], "active") '
        href="@route(getRouteName().'.empcategory.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">الاقسام</span>
    </a>
</li>


<li
    class='sidebar-item @isActive([getRouteName().".employee.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".employee.read"], "active") '
        href="@route(getRouteName().'.employee.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">الموظفين</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".empadvance.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".empadvance.read"], "active") '
        href="@route(getRouteName().'.empadvance.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">السلف</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".salary.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".salary.read"], "active") '
        href="@route(getRouteName().'.salary.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu">الرواتب</span>
    </a>
</li>

<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">نظام الديون</span></li>

<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu"> الديون الثابتة</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
      
        <li class="sidebar-item @isActive(getRouteName().'.'.'fdebitcategory'.'.read')">
            <a href="@route(getRouteName().'.fdebitcategory.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'fdebitcategory'.'.read')">
                <span class="hide-menu"> اصناف الديون </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'fdebittransaction'.'.create')">
            <a href="@route(getRouteName().'.fdebittransaction.create')"
                class="sidebar-link @isActive(getRouteName().'.'.'fdebittransaction'.'.create')">
                <span class="hide-menu"> وصل صرف </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'fdebittransaction'.'.read')">
            <a href="@route(getRouteName().'.fdebittransaction.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'fdebittransaction'.'.read')">
                <span class="hide-menu"> القائمة </span>
            </a>
        </li>

       
        
    </ul>





</li>


<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i data-feather="{{ get_icon("money") }}" class="feather-icon"></i>
        <span class="hide-menu"> الديون المتغيرة</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
      
        <li class="sidebar-item @isActive(getRouteName().'.'.'debitaccount'.'.read')">
            <a href="@route(getRouteName().'.debitaccount.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'debitaccount'.'.read')">
                <span class="hide-menu"> الحسابات </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'debittransaction'.'.create')?payment_type=1">
            <a href="@route(getRouteName().'.debittransaction.create')?payment_type=2"
                class="sidebar-link @isActive(getRouteName().'.'.'debittransaction'.'.create')">
                <span class="hide-menu"> وصل قبض </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'debittransaction'.'.create')?payment_type=2">
            <a href="@route(getRouteName().'.debittransaction.create')?payment_type=1"
                class="sidebar-link @isActive(getRouteName().'.'.'debittransaction'.'.create')">
                <span class="hide-menu"> وصل صرف </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'debittransaction'.'.read')">
            <a href="@route(getRouteName().'.debittransaction.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'debittransaction'.'.read')">
                <span class="hide-menu"> القائمة </span>
            </a>
        </li>






       
        
    </ul>





</li>

@endif

<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">القائمة العامة</span></li>

@if(Auth::user()->user_type  == "info" || Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "superadmin" ||  Auth::user()->user_type  == "tabq" )
<li
    class='sidebar-item @isActive([getRouteName().".patient.read", getRouteName().".patient.create", getRouteName().".patient.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".patient.read", getRouteName().".patient.create", getRouteName().".patient.update"], "active") '
        href="@route(getRouteName().'.patient.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">المرضى</span>
    </a>
</li>
@endif

@if(Auth::user()->user_type  == "tabq")
<li
    class='sidebar-item @isActive([getRouteName().".followup.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".followup.read"], "active") '
        href="@route(getRouteName().'.followup.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("note") }}" class="feather-icon"></i>
        <span class="hide-menu">ملاحظات الممرضة والعلاج</span>
    </a>
</li>
@endif

@if(Auth::user()->user_type  == "info")

<li
    class='sidebar-item @isActive([getRouteName().".operation.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".operation.read"], "active") '
        href="@route(getRouteName().'.operation.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">العمليات</span>
    </a>
</li>



<li
    class='sidebar-item @isActive([getRouteName().".setting.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".setting.update"], "active") '
        href="@route(getRouteName().'.setting.update', ['setting' => 1])" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">الأطباء</span>
    </a>
</li>
<li
    class='sidebar-item @isActive([getRouteName().".user.read"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".user.read"], "active") '
    href="@route(getRouteName().'.user.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("users") }}" class="feather-icon"></i>
        <span class="hide-menu">المستخدمين</span>
    </a>
</li>


@endif





@if(Auth::user()->user_type  == "doctor" ||  Auth::user()->user_type  == "superadmin" )

<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i  class="fa fa-stethoscope"></i>
        <span class="hide-menu"> العيادة الأستشارية</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
      
        <li class="sidebar-item @isActive(getRouteName().'.'.'checkup'.'.converted')">
            <a href="@route(getRouteName().'.checkup.converted')"
                class="sidebar-link @isActive(getRouteName().'.'.'checkup'.'.converted')">
                <span class="hide-menu"> المرضى الداخلين </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'checkup'.'.read')">
            <a href="@route(getRouteName().'.checkup.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'checkup'.'.read')">
                <span class="hide-menu"> الملفات السابقة </span>
            </a>
        </li>

       
        
    </ul>





</li>
@endif

@if(Auth::user()->user_type  == "sonar" ||  Auth::user()->user_type  == "superadmin" )
<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i  class="fa fa-stethoscope"></i>
        <span class="hide-menu">قسم السونار</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
        <li class="sidebar-item @isActive(getRouteName().'.'.'sonar'.'.converted')">
            <a href="@route(getRouteName().'.sonar.converted')"
                class="sidebar-link @isActive(getRouteName().'.'.'sonar'.'.converted')">
                <span class="hide-menu"> المرضى الداخلين </span>
            </a>
        </li>
        <li class="sidebar-item @isActive(getRouteName().'.'.'sonar'.'.read')">
            <a href="@route(getRouteName().'.sonar.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'sonar'.'.read')">
                <span class="hide-menu"> الملفات السابقة </span>
            </a>
        </li>

       
        
    </ul>





</li>

@endif

@if(Auth::user()->user_type  == "rays" ||  Auth::user()->user_type  == "superadmin" )
<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i  class="fa fa-x-ray"></i>
        <span class="hide-menu">قسم الأشعة</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
        <li class="sidebar-item @isActive(getRouteName().'.'.'rays'.'.converted')">
            <a href="@route(getRouteName().'.rays.converted')"
                class="sidebar-link @isActive(getRouteName().'.'.'rays'.'.converted')">
                <span class="hide-menu"> المرضى الداخلين </span>
            </a>
        </li>
        <li class="sidebar-item @isActive(getRouteName().'.'.'rays'.'.read')">
            <a href="@route(getRouteName().'.rays.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'rays'.'.read')">
                <span class="hide-menu"> الملفات السابقة </span>
            </a>
        </li>

       
        
    </ul>





</li>
@endif


@if(Auth::user()->user_type  == "lab" ||  Auth::user()->user_type  == "superadmin")
<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i  class="fa fa-flask"></i>
        <span class="hide-menu">قسم المختبر</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">
    @if(Auth::user()->user_type  == "lab" ||  Auth::user()->user_type  == "superadmin")
   

        <li class="sidebar-item @isActive(getRouteName().'.'.'lab'.'.pat')">
            <a href="@route(getRouteName().'.lab.pat')"
                class="sidebar-link @isActive(getRouteName().'.'.'lab'.'.pat')">
                <span class="hide-menu"> اعادة توجيه المرضى </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'lab'.'.converted')">
            <a href="@route(getRouteName().'.lab.converted')"
                class="sidebar-link @isActive(getRouteName().'.'.'lab'.'.converted')">
                <span class="hide-menu"> المرضى الداخلين </span>
            </a>
        </li>

      

        @endif
        <li class="sidebar-item @isActive(getRouteName().'.'.'lab'.'.read')">
            <a href="@route(getRouteName().'.lab.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'lab'.'.read')">
                <span class="hide-menu"> فحوصات المرضى </span>
            </a>
        </li>
        @if(Auth::user()->user_type  == "lab" ||  Auth::user()->user_type  == "superadmin")
        <li class="sidebar-item @isActive(getRouteName().'.'.'labtest'.'.read')">
            <a href="@route(getRouteName().'.labtest.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'labtest'.'.read')">
                <span class="hide-menu"> تهئية الفحوصات </span>
            </a>
        </li>
        @endif

        <!-- Lab Stock Management -->
        @if(Auth::user()->user_type  == "lab" ||  Auth::user()->user_type  == "superadmin")
        <li class='sidebar-item'>
            <a class='sidebar-link' href="@route(getRouteName().'.labstock.read')">
                
                <span class="hide-menu"> إدارة مخزون المختبر </span>
            </a>
           
        </li>
        @endif



    </ul>





</li>
@endif

@if(Auth::user()->user_type  == "tabq" )
<li class="sidebar-item @isActive(getRouteName().'.'.'lab'.'.read')">
            <a href="@route(getRouteName().'.lab.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'lab'.'.read')">
                <span class="hide-menu">
                <i  class="fa fa-flask"></i>
                     فحوصات المرضى
                     </span>
            </a>
        </li>
@endif

@if(Auth::user()->user_type  == "accountant" ||  Auth::user()->user_type  == "stockmanagment" ||  Auth::user()->user_type  == "superadmin" )
<li class='sidebar-item'>

    

    <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
        <i  class="fa fa-box"></i>
        <span class="hide-menu">المخزن</span>
    </a>

    <ul aria-expanded="false" class="collapse first-level base-level-line">

    <li class="sidebar-item @isActive(getRouteName().'.'.'stocksup'.'.read')">
            <a href="@route(getRouteName().'.stocksup.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'stocksup'.'.read')">
                <span class="hide-menu"> الأقسام والشركات </span>
            </a>
        </li>


        <li class="sidebar-item @isActive(getRouteName().'.'.'stockcat'.'.read')">
            <a href="@route(getRouteName().'.stockcat.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'stockcat'.'.read')">
                <span class="hide-menu"> الفئات </span>
            </a>
        </li>

    <li class="sidebar-item @isActive(getRouteName().'.'.'unit'.'.read')">
            <a href="@route(getRouteName().'.unit.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'unit'.'.read')">
                <span class="hide-menu"> الوحدات </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'warehouse'.'.read')">
            <a href="@route(getRouteName().'.warehouse.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'warehouse'.'.read')">
                <span class="hide-menu"> القوائم </span>
            </a>
        </li>
        
        <li class="sidebar-item @isActive(getRouteName().'.'.'warehouseitem'.'.read')">
            <a href="@route(getRouteName().'.warehouseitem.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'warehouseitem'.'.read')">
                <span class="hide-menu"> المواد </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'warehouseexport'.'.read')">
            <a href="@route(getRouteName().'.warehouseexport.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'warehouseexport'.'.read')">
                <span class="hide-menu"> الطلبات </span>
            </a>
        </li>

        <li class="sidebar-item @isActive(getRouteName().'.'.'stockreport'.'.read')">
            <a href="@route(getRouteName().'.'.'stockreport'.'.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'stockreport'.'.read')">
                <span class="hide-menu"> كشف قسم </span>
            </a>
        </li>

       
        
    </ul>





</li>

@endif


@if(Auth::user()->user_type  == "operation")
<li
    class='sidebar-item @isActive([getRouteName().".operationhold.list"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".operationhold.list"], "active") '
        href="@route(getRouteName().'.operationhold.list')" aria-expanded="false">
        <i data-feather="{{ get_icon("file") }}" class="feather-icon"></i>
        <span class="hide-menu">العمليات</span>
    </a>
</li>
<li class="sidebar-item @isActive(getRouteName().'.'.'lab'.'.read')">
            <a href="@route(getRouteName().'.lab.read')"
                class="sidebar-link @isActive(getRouteName().'.'.'lab'.'.read')">
                <i data-feather="{{ get_icon("file") }}" class="feather-icon"></i>
                <span class="hide-menu"> فحوصات المرضى </span>
            </a>
        </li>
@endif