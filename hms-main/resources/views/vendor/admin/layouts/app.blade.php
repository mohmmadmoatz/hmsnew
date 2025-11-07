<!DOCTYPE html>
<html dir="{{ config('easy_panel.rtl_mode') ? 'rtl' : 'ltr' }}" lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> صحة المرأة -  {{ $title ?? __('Home') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    {{--Scripts which must load before full loading--}}
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">

    <script src="{{asset('assets/admin/js/html5shiv.js')}}"></script>
    <script src="{{asset('assets/admin/js/respond.min.js')}}"></script>
   

  

    {{--Styles--}}
    @livewireStyles
    <link rel="stylesheet" href="{{asset('assets/admin/css/style.min.css')}}">
    
    @if(config('easy_panel.rtl_mode'))
    <link rel="stylesheet" href="{{asset('assets/admin/css/rtl.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-face.css')}}">

       
    @endif
</head>

<body>

<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <!-- Topbar header - style you can find in pages.scss -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md">
            <div class="navbar-header" data-logobg="skin6">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>

                <!-- Logo -->
                <div class="navbar-brand">
                    <a href="@route(getRouteName().'.home')">
                        <span class="logo-text">
                        <img  src="{{asset('formimages/hmslogo.png')}}" width="180px" >
                        </span>
                    </a>
                </div>
                <!-- End Logo -->

                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                        class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left ml-auto ml-3 pl-1">
                    <!-- Notification -->

                    @if(Auth::user()->user_type  == "info" ||  Auth::user()->user_type  == "superadmin" || Auth::user()->user_type  == "accountant")
                    <a href="@route(getRouteName().'.patient.create')"  class="btn btn-info"> مريض جديد <i class="fa fa-plus"></i> </a>
                    @endif

                    @if(Auth::user()->user_type  == "superadmin")
                    <!-- <a href="@route('backup')"  class="btn btn-success mx-2"> رفع البيانات  <i class="fa fa-upload"></i> </a> -->
                    @endif

                    @if(config('easy_panel.todo'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                               id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge badge-primary notify-no rounded-circle">{{ \EasyPanel\Models\Todo::where('user_id', auth()->user()->id)->where('checked', false)->count() }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="message-center notifications position-relative">
                                            <!-- Todos Messages -->
                                            @include('admin::layouts.todo-message')
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark"
                                           href="@route(getRouteName().'.todo.lists')">
                                            <strong>{{ __('See TODO list') }}</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                @endif
                <!-- End Notification -->
                </ul>

                <!-- Right side toggle and nav items -->
                <ul class="navbar-nav float-right">
                    <!-- User profile and search -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                                <span class="ml-2 d-none d-lg-inline-block"><span>{{ __('Hello') }},</span> <span
                                        class="text-dark">@user('name')</span> <i data-feather="chevron-down"
                                                                                  class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated pb-0 flipInY">
                            <a class="dropdown-item" href="javascript:void(0)"
                               onclick="event.preventDefault(); document.querySelector('#logout').submit()"><i
                                    data-feather="power"
                                    class="svg-icon mr-2 ml-1"></i>
                                {{ __('Logout') }}</a>
                            <form id="logout" action="@route(getRouteName().'.logout')" method="post"> @csrf </form>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- End Topbar header -->

    <!-- Left Sidebar -->
@include('admin::layouts.sidebar')
<!-- End Left Sidebar -->


    <!-- Page wrapper  -->
    <div class="page-wrapper">

        <!-- Container -->
        <div class="container-fluid">

            {{ $slot }}

        </div>
        <!-- End Container fluid  -->

        <!-- footer -->
        <footer class="footer text-center text-muted">Created By  Genius Solutions</footer>
        <!-- End footer -->
    </div>
</div>
<!-- End Wrapper -->

<!-- All Scripts -->
<script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/app-style-switcher.min.js')}}"></script>
<script src="{{asset('assets/admin/js/feather.min.js')}}"></script>
<script src="{{asset('assets/admin/js/sidebarmenu.min.js')}}"></script>
<script src="{{asset('assets/admin/js/custom.min.js')}}"></script>




@livewireScripts



<script src="{{asset('assets/admin/js/moment.min.js')}}"></script>
<script src="{{asset('assets/admin/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">




<script type="text/javascript">
$(function() {
//     const canvas = document.getElementById("sig")

//     const signaturePad = new SignaturePad(canvas);
    
//     document.getElementById('clearsig').addEventListener('click', function () {
//         signaturePad.clear();
// });


   

  

 	 var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'اليوم': [moment(), moment()],
           'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'اخر 7 ايام': [moment().subtract(6, 'days'), moment()],
           'اخر 30 يوم': [moment().subtract(29, 'days'), moment()],
           'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
           'الشهر السابق': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
		
		  "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "اختيار",
        "cancelLabel": "الغاء",
        "fromLabel": "من",
        "toLabel": "الى",
        "customRangeLabel": "مخصص",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
		  }
		
    },
	cb);

    cb(start, end);
    
});
</script>


<script src="{{asset('assets/admin/js/alpine.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-select.min.js')}}"></script>



<script>
                        $(function () {
        $('.selectpicker2').selectpicker();
        });
                    </script>

<script>

window.addEventListener('refselect', function (event) {
        console.log("ok i will refresh")
        $('.selectpicker').selectpicker();
     
    })
    

window.addEventListener('open-window', function (event) {
        let url = event.detail.url;
        window.open(url);
    })

    window.addEventListener('refreshselect', function () {
        $(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    })

    window.addEventListener('show-message', function (event) {
        let type = event.detail.type;
        let message = event.detail.message;
        if (document.querySelector('.notification')) {
            document.querySelector('.notification').remove();
        }
        let body = document.querySelector('#main-wrapper');
        let child = document.createElement('div');
        child.classList.add('notification', 'notification-' + type, 'animate__animated', 'animate__jackInTheBox');
        child.innerHTML = `<p>${message}</p>`;

        body.appendChild(child);

        setTimeout(function () {
            body.removeChild(child);
        }, 3000);
    });
</script>





</body>

</html>
