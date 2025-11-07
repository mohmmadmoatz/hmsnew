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

    $stage = $_GET['stage'];
    $stagedata = App\Models\Stage::find($stage);

    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];

    

     $payments = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
     ->where("operation_id",0)
     ->where("payment_type",2);

     if($stage){
       $payments= $payments->where("redirect",$stage);
     }

     $payments= $payments->where("redirect","!=",2);

    $payments = $payments->get();
    $operation = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
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
                </tr>
                <tr>
                    <th>
                        كشف حسابات المستشفى
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                </tr>
        </table>
        @if(!$stage)
        <h4 style="    text-align: right;">العمليات</h4>
        <div class="card-body table-responsive p-0">

     
        <table class="table table-bordered table-striped">

              <thead>
                 <tr>
              
                    
                      <th>الأيراد</th>
                      <th>نسبة الطبيب</th>
                      <th>نسبة المستشفى</th>
                      <!-- <th>تفاصيل الاستقطاع من نسبة المستشفى</th> -->
                      <th>صافي ايراد المستشفى</th>
              
                 </tr>
                 </thead>

       
  <!-- Operations -->

            @foreach($operation as $item)
            @php
              $payment = App\Models\Payments::where("payment_type",2)->where("wasl_number",$item->payment_number)->first();
            @endphp
            <tr>
          
                <td>@convert($item->operation_price) د.ع </td>
                <td>@convert($item->doctorexp) د.ع</td>
                <td>@convert($item->operation_price - $item->doctorexp) د.ع</td>

                <!-- <td> 
                  مساعد جراح : 
                  @convert($item->helper) د.ع
                  <hr>
                  مخدر : 
                  @convert($item->m5dr) د.ع
                  <hr>
                  مساعد مخدر : 
                  @convert($item->helperm5dr) د.ع

                  <hr>
                  ممرضة : 
                  @convert($item->nurse_price) د.ع

                  <hr>
                  اسعاف طفل : 
                  @convert($item->ambulance) د.ع
                  <hr>
                  الأجمالي : @convert($item->helper + $item->m5dr + $item->helperm5dr + $item->nurse_price + $item->ambulance)  د.ع

                </td> -->

                <td>
                  <!-- To do status -->

                  @convert(($item->operation_price - $item->doctorexp) - ($item->helper + $item->m5dr + $item->helperm5dr + $item->nurse_price + $item->ambulance) ) د.ع
                </td>
            
           </tr>

            @endforeach


      

    </table>
    @endif
    </div>
 
    @if($stage)
    <h4 style="text-align: right;">{{$stagedata->name}}</h4>
    @else
    <h4 style="text-align: right;">العام</h4>

    @endif   
    <table class="table table-bordered table-striped">

      <thead>
             <tr>
                
                  <th>الأيراد</th>
                  <th>وذالك عن</th>
                  <th>نسبة الطبيب</th>
                  <th>نسبة المستشفى</th>
                  <th>التوجيه</th>
              
                  <th>صافي ايراد المستشفى</th>
             </tr>
      </thead>

      <tbody>
<!-- Operations -->

        @foreach($payments as $item)
        @php
        $doctorprice = $item->redirect_doctor_price;
        if(!$doctorprice){
          $doctorprice =0; 
        }
        @endphp
        <tr>
          
         
            <td>@convert($item->amount_iqd) د.ع / @convert($item->amount_usd) $</td>
            <td>{{$item->description}}</td>
            <td>@convert($doctorprice ?? 0) د.ع</td>
            <td>@convert($item->amount_iqd - $doctorprice) د.ع / @convert($item->amount_usd) $</td>

            <td>
              @if($item->redirect)
             
                  {{$item->stagename->name ??""}}
              @endif
            </td>

            <td>@convert($item->amount_iqd - $doctorprice) د.ع / @convert($item->amount_usd) $</td>
            
        
       </tr>

        @endforeach


      </tbody>

</table>

      
     
    </div>
  </div>

  


</body>

</html>