<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
</head>

<style>
        @font-face {
  font-family: tajwal;
  src: url({{asset('css/Tajawal-Regular.ttf')}});
}
    body {
    font-family: tajwal;

  }
  h3{
    font-family: tajwal !important;
  }
  h4{
    font-family: tajwal !important;
  }
  h5{
    font-family: tajwal !important;
  }

  table{
      text-align: right;
  }

  @media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
.table-striped tbody tr:nth-of-type(odd) td {
    background-color: rgba(0,0,0,.05) !important;
}
.table-striped tbody tr:nth-of-type(odd) th {
    
    background-color: rgba(0,0,0,.05) !important;
}


</style>



<body dir="rtl">

    @php
  
    $st = $_GET['stage'];
    $type = $_GET['type'];
    $stage = App\Models\Stage::find($st);
    $dates = $_GET['daterange'];
    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];
    $doctor="";
    $doctorname="";
    if(isset($_GET['doctor_id'])){
      $doctor = $_GET['doctor_id'];
      $doctorname = App\Models\User::find($doctor);

    }

    $data = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("redirect",$st);

    if($doctor && $type=="doctor"){
      $data=$data->where("redirect_doctor_id",$doctor);
    }


    if($type=="doctor"){
        $data = $data->whereNull("redirect_doctor_paid")->get();
    }else{
        $data = $data->whereNull("redirect_nurse_paid")->get();
    }
    
    $canpay = true;

    if($type=="doctor"){
    if(count($data)){
      $firstRef = $data[0];
      foreach($data as $item){
        if($item->redirect_doctor_id != $firstRef->redirect_doctor_id){
          $canpay = false;
        }
      }
    }
  }

    

    @endphp

  <div class="py-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12" align="center">
          <img  src="{{asset('formimages/hmslogo.png')}}" width="250px">
        </div>
      </div>
      
        
        <table class="table">
                <tr>
                    <th>تقرير</th>
                    <th>الفترة</th>
                    <th>تاريخ التقرير</th>
                    <th class="no-print"></th>
                </tr>
                <tr>
                    <th>
                        @if($type=="doctor")
                        اجور الطبيب  من 
                        @endif

                        @if($type=="nurse")
                        اجور الممرضة من 
                        @endif
                    {{$stage->name}}
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>

                    <th class="no-print">
                    @if($canpay)
                    @if($type=="doctor")
                    <a   href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=3&daterange={{$dates}}&amount_iqd={{$data->sum('redirect_doctor_price')}}&payto=doctorfromstage&stname={{$stage->name}}&stid={{$stage->id}}&paydoctor={{$doctor}}">دفع وطباعة</button>
                    @else
                    <a   href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=3&daterange={{$dates}}&amount_iqd={{$data->sum('redirect_nurse_price')}}&payto=nursefromstage&stname={{$stage->name}}&stid={{$stage->id}}">دفع وطباعة</button>

                    @endif
                    @endif
                    </th>
                  
                </tr>
        </table>

        <hr>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>رقم الوصل</th>
              <th>التاريخ</th>
              <th>اسم المريض</th>
              @if($type=="doctor")
              <th>اجور الطبيب</th>
              @endif

              @if($type=="nurse")
              <th>اجور الممرضة</th>
              @endif
      
          </tr>
          </thead>
                
                @foreach($data as $item)
                <tr>
                    <td>{{$item->wasl_number}}</td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->patient->name ?? ""}}</td>
                    
                    @if($type=="doctor")
                    <td>@convert($item->redirect_doctor_price)</td>
                    @endif

                    @if($type=="nurse")
                    <td>@convert($item->redirect_nurse_price)</td>
                    @endif
                  
                    
                </tr>
                @endforeach
                <tr>
                    <td colspan="2">المجموع</td>
                    <td style="font-weight: bold;">

                    @if($type=="doctor")
                        @convert($data->sum("redirect_doctor_price")) د.ع
                    @endif

                    @if($type=="nurse")
                        @convert($data->sum("redirect_nurse_price")) د.ع
                    @endif
                        
                      
                      
                    </td>
                    <td></td>
                   
                </tr>
               
        </table>

      
     
    </div>
  </div>

  


</body>

</html>