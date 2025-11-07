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
    
    $dates = $_GET['daterange'];

$date1 = explode(" - ", $dates)[0];
$date2 = explode(" - ", $dates)[1];
 
    
    $data =  App\Models\OperationHold::whereNull("helperm5dr_paid")
    ->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->get();
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
                    <th></th>
                </tr>
                <tr>
                    <th>
                        مساعد مخدر
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                    <th class="no-print">
                      <a   href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=3&account_id=مساعد مخدر&daterange={{$dates}}&amount_iqd={{$data->sum('helperm5dr')}}&payto=helperm5dr">دفع وطباعة</button>
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
              <th>اجور مساعد مخدر</th>
              <th>العملية</th>
          </tr>
          </thead>
             
                @foreach($data as $item)
                <tr>
                <td>{{$item->payment_number}}</td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->patient->name}}</td>
                  
                    <td>
                        @convert($item->helperm5dr) د.ع
                      
                    </td>
                    <td>{{$item->operation_name}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">المجموع</td>
                    <td style="font-weight: bold;">
                        @convert($data->sum("helperm5dr")) د.ع
                      
                    </td>
                    <td></td>
                </tr>
        </table>

   
     
    </div>
  </div>

  


</body>

</html>