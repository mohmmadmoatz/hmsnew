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
   
  html{
  height: 100%;
  }

body{
  position: relative;
  height: 100%;
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
   
    $data = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])->get();
    
    $iqd = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])->select(DB::raw('SUM(amount_iqd - return_iqd) as amount_iqd'))->first()->amount_iqd;
    $usd = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])->select(DB::raw('SUM(amount_usd - return_usd) as amount_usd'))->first()->amount_usd;

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
                </tr>
                <tr>
                    <th>
                     مقبوضات
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                </tr>
        </table>

        <hr>
        <div class="card-body table-responsive p-0">

        <table class="table table-bordered table-striped">
          <thead>
                <tr>
                    <th>رقم الوصل</th>
                    <th>التاريخ</th>
                    <th>اسم المريض</th>
                    <th>المبلغ</th>
                    <th>مرجع</th>
                    <th>العملية</th>
                </tr>
</thead>
                @foreach($data as $item)
                <tr>
                    <td>{{$item->wasl_number}}</td>
                    <td style="width:110px">{{$item->date}}</td>
                    <td>{{$item->patient->name ?? ""}}</td>
                  
                    <td>
                        @convert($item->amount_iqd) د.ع
                      
                       /
                       @convert($item->amount_usd) $

                
                    </td>
                    <td>
                        @convert($item->return_iqd) د.ع
                      
                       /
                       @convert($item->return_usd) $

                
                    </td>
                    <td>{{$item->description}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">المجموع</td>
                    <td style="font-weight: bold;">

                      

                        @convert($data->sum("amount_iqd")) د.ع

                        / 
                        @convert($data->sum("amount_usd")) د.ع
                      
                      
                    </td>
                    <td style="font-weight: bold;">
                    @convert($data->sum("return_iqd")) د.ع

/ 
@convert($data->sum("return_usd")) د.ع
                    </td>
                    <td></td>
                </tr>
                <tr>
                  <td colspan="3">الصافي</td>
              
                  <td colspan="4" style="font-weight: bold;">     
                     @convert($iqd) د.ع

                    / 
                    @convert($usd) $</td>
                </tr>
        </table>
</div>

    
     
    </div>
  </div>

  


</body>

</html>