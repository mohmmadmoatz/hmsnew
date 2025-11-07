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
    $id = $_GET['id'];
    $dates = $_GET['daterange'];
    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];
    
    $doctor = App\Models\User::find($id);

    if($doctor->user_type == "resident"){
      $data = App\Models\OperationHold::where("mqema_id",$id)
    ->whereNull("mqema_paid")
    ->where("operation_name","ولادة طبيعية")
    ->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->get();
    }else{
      $data = App\Models\OperationHold::where("doctor_id",$id)
    ->whereNull("doctor_paid")
    ->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->get();

    }

    foreach($data as $item){
      $subvalue = $item->outexp * ($item->nsba / 100);
                  $item->doctornet = $item->doctorexp - $subvalue;
    }
  
    @endphp

  <div class="py-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" align="center">
          <img  src="{{asset('formimages/hmslogo.png')}}" width="250px">
        </div>
      </div>
    
        
        <table class="table">
          <thead>

          
                <tr>
                    <th>الدكتور</th>
                    <th>الفترة</th>
                    <th>تاريخ التقرير</th>
                    <th class="no-print"></th>
                </tr>
              </thead>
                <tr>
                    <th>
                        {{$doctor->name ??""}}
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>

                    <th class="no-print">
   @if($doctor->user_type == "resident")
                      <a  href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=1&account_id={{$doctor->id ??''}}&daterange={{$dates}}&amount_iqd={{$data->sum('mqema_price')}}&payto=mqema">دفع وطباعة</button>
     @else
     <a   href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=1&account_id={{$doctor->id ??''}}&daterange={{$dates}}&amount_iqd={{$data->sum('doctornet')}}&payto=doctor">دفع وطباعة</button>
     
     @endif
                    </th>
                   
                </tr>
        </table>

        <hr>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>رقم القبض</th>
              <th>التاريخ</th>
              <th>اسم المريض</th>
              <th>سعر العملية</th>
              <th>مصاريف العملية</th>
               @if($doctor->user_type=="doctor")  <th>نسبة الطبيب</th> @endif
              <th>اجور الطبيب</th>
              <th>صافي اجور الطبيب</th>
              <th>العملية</th>
          </tr>
          </thead>
               
                @foreach($data as $item)
             
                <tr>
                   <td>{{$item->payment_number}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->patient->name ?? ""}}</td>
                    <td>@convert($item->operation_price == "" ? 0 :$item->operation_price)</td>
                    <td>
                      @convert($item->outexp)
                    </td>

                    @if($doctor->user_type=="doctor")  <td>{{$item->nsba ?? "0"}} %</td> @endif
                    
                    <td>
                      @if($doctor->user_type=="doctor")
                        @convert($item->doctorexp) د.ع
                     @else
                     @convert($item->mqema_price) د.ع
                     @endif
                    </td>
 @if($doctor->user_type=="doctor") 
                    <td>
                      @convert($item->doctornet) د.ع
                    </td>
                    @endif

                    <td>{{$item->operation_name}}</td>
                </tr>
                @endforeach
                <tr>
                    <td  @if($doctor->user_type=="doctor") colspan="6" @else colspan="4" @endif >المجموع</td>
                    <td style="font-weight: bold;">
                    @if($doctor->user_type=="doctor")
                        @convert($data->sum("doctorexp")) د.ع
                      @else
                      @convert($data->sum("mqema_price")) د.ع
                      @endif
                    </td>
                    <td style="font-weight:bold">
                    @if($doctor->user_type=="doctor")
                      @convert($data->sum("doctornet")) د.ع
                    @endif
                    </td>
                </tr>
        </table>

    
     
    </div>
  </div>

  


</body>

</html>