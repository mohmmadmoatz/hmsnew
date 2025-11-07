<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">{{ __('Menu') }}</span></li>
@if(Auth::user()->user_type  == "superadmin")
@foreach(config('easy_panel.actions') as $name)
    <li class='sidebar-item @isActive([getRouteName().".$name.read", getRouteName().".$name.create", getRouteName().".$name.update"], "selected")'>
        <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
            <i data-feather="{{ get_icon($name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ __(\Illuminate\Support\Str::plural(ucfirst($name))) }}</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level base-level-line">
            <li class="sidebar-item @isActive(getRouteName().'.'.$name.'.read')">
                <a href="@route(getRouteName().'.'.$name.'.read')" class="sidebar-link @isActive(getRouteName().'.'.$name.'.read')">
                    <span class="hide-menu"> {{ __('List') }} </span>
                </a>
            </li>
            @if(config('easy_panel.crud.'.$name.'.create'))
                <li class="sidebar-item @isActive(getRouteName().'.'.$name.'.create')">
                    <a href="@route(getRouteName().'.'.$name.'.create')" class="sidebar-link @isActive(getRouteName().'.'.$name.'.create')">
                        <span class="hide-menu"> {{ __('Create') }} </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endforeach
@endif
@if(Auth::user()->user_type  == "info" || Auth::user()->user_type  == "accountant")
<li
    class='sidebar-item @isActive([getRouteName().".patient.read", getRouteName().".patient.create", getRouteName().".patient.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".patient.read", getRouteName().".patient.create", getRouteName().".patient.update"], "active") '
        href="@route(getRouteName().'.patient.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">المرضى</span>
    </a>
</li>
@endif
@if(Auth::user()->user_type  == "accountant")

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
        <i data-feather="{{ get_icon("dollar") }}" class="feather-icon"></i>
        <span class="hide-menu">كشف حساب المرضى</span>
    </a>
</li>

<li
    class='sidebar-item @isActive([getRouteName().".payments.read", getRouteName().".payments.create", getRouteName().".payments.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".payments.read", getRouteName().".payments.create", getRouteName().".payments.update"], "active") '
        href="@route(getRouteName().'.payments.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("dollar") }}" class="feather-icon"></i>
        <span class="hide-menu">السندات</span>
    </a>
</li>
@endif


@if(Auth::user()->user_type  == "info")
<li
    class='sidebar-item @isActive([getRouteName().".room.read", getRouteName().".room.create", getRouteName().".room.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".room.read", getRouteName().".room.create", getRouteName().".room.update"], "active") '
        href="@route(getRouteName().'.room.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">الغرف</span>
    </a>
</li>

@endif

<!-- if(Auth::user()->user_type  == "doctor") -->
@if(Auth::user()->user_type  == "doctor")
<li
    class='sidebar-item @isActive([getRouteName().".checkup.read", getRouteName().".checkup.create", getRouteName().".checkup.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".checkup.read", getRouteName().".checkup.create", getRouteName().".checkup.update"], "active") '
        href="@route(getRouteName().'.checkup.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">Check up</span>
    </a>
</li>
@endif

@if(Auth::user()->user_type  == "rays")
<li
    class='sidebar-item @isActive([getRouteName().".rays.read", getRouteName().".rays.create", getRouteName().".rays.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".rays.read", getRouteName().".rays.create", getRouteName().".rays.update"], "active") '
        href="@route(getRouteName().'.rays.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">Rays</span>
    </a>
</li>
@endif

@if(Auth::user()->user_type  == "sonar")
<li
    class='sidebar-item @isActive([getRouteName().".sonar.read", getRouteName().".sonar.create", getRouteName().".sonar.update"], "selected")'>
    <a class='sidebar-link @isActive([getRouteName().".sonar.read", getRouteName().".sonar.create", getRouteName().".sonar.update"], "active") '
        href="@route(getRouteName().'.sonar.read')" aria-expanded="false">
        <i data-feather="{{ get_icon("list") }}" class="feather-icon"></i>
        <span class="hide-menu">Sonar</span>
    </a>
</li>
@endif

@if(config('easy_panel.todo'))
    <li class="sidebar-item @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'selected')">
        <a class="sidebar-link @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'active') " href="@route(getRouteName().'.todo.lists')" aria-expanded="false">
            <i data-feather="grid" class="feather-icon"></i>
            <span class="hide-menu">{{ __('Todo') }}</span>
        </a>
    </li>
@endif
