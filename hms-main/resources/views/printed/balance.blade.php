<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
  <title>رصيد الصندوق</title>
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

  .table-striped tbody tr:nth-of-type(odd) th {
    background-color: rgba(0, 0, 0, .05)!important;
}




</style>

<style>
 .table.table-fit {
    width: max-content !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}
                
        </style>

<body dir="rtl">

    @php
    $setting = App\Models\Setting::find(1);

    $dates = $_GET['daterange'] ??"";

    if($dates){
      $date1 = explode(" - ", $dates)[0];
      $date2 = explode(" - ", $dates)[1];
    }
    

    $debit = App\Models\Payments::where("date",">",$setting->box_date);

    
    if($dates){
      $debit = $debit->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"]);
    }
   
    
    $debit =  $debit->where("payment_type",2)->get();


    $credit = App\Models\Payments::where("date",">",$setting->box_date);

    if($dates){
      $credit = $credit->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"]);

    }
    
    $credit = $credit->where("payment_type",1)->get();
   



    @endphp

  <div class="py-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" align="center">
          <img  src="{{asset('formimages/hmslogo.png')}}" width="250px">
        </div>
      </div>
      <div class="row py-3">
        
        <table class="table">
                <tr>
                    <th>تقرير</th>
                    <th>الفترة</th>
                    <th>تاريخ التقرير</th>
                    <th></th>
                </tr>
                <tr>
                    <th>
                        الرصيد
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                    <th></th>
                </tr>

                <tr>
                    <th>
                        مدين
                    </th>
                    <th>
                        @convert($debit->sum("amount_iqd")) د.ع | @convert($debit->sum("amount_usd")) دولار
                    </th>
                    <th>
                    دائن 
                    </th>
                    <th>
                    @convert($credit->sum("amount_iqd")) د.ع | @convert($credit->sum("amount_usd")) دولار
                    </th>
                </tr>

                <tr>
                    <th>رصيد الصندوق</th>
                    <th colspan="3">
                     <span dir="ltr">
                     @convert($debit->sum("amount_iqd") - $credit->sum("amount_iqd")) د.ع 
                     </span> 
                       <span>|</span> 
                      <span dir="ltr">
                       @convert($debit->sum("amount_usd") - $credit->sum("amount_usd")) $
                     </span> 
                    
                    </th>
                </tr>

               

        </table>

        <hr>
      
        <div class="row">
        <div align="right" class="col-md-6">
                <h4
                style="
    text-align: center;
    color: green;
    font-weight: bold;
"
                >مدين</h4>
                <table class="table table-bordered table-striped table-fit">
        
        <thead>
                 <tr>
                      <th>رقم الوصل</th>
                      <th>الحساب</th>
                      <th>دينار</th>
                      <th>دولار</th>
                      <th>التوجيه</th>
                      
                 </tr>
          </thead>

    <tbody>

    @foreach($debit as $payments)
    <tr>
    <th>{{$payments->wasl_number}}</th>
    <th>
    @if($payments->account_type==1) <span> طبيب <br> {{ $payments->doctor->name ??""}} </span> @endif
    @if($payments->account_type==2) <span> مريض <br> {{ $payments->Patient->name ??""}} </span> @endif
    @if($payments->account_type==3) <span> نقدي <br> {{ $payments->account_name ??""}} </span> @endif
    </th>
    <th>@convert($payments->amount_iqd)</th>
    <th>@convert($payments->amount_usd)</th>
    <th> {{$payments->stagename->name ??""}}</td>
   
    </tr>
    @endforeach
    
</tbody>

                </table>
            </div>
            <div align="left" class="col-md-6">
            <h4
                style="
    text-align: center;
    color: red;
    font-weight: bold;
"
                >دائن</h4>
            <table class="table table-bordered table-striped table-fit">
        
        <thead>
                 <tr>
                      <th>رقم الوصل</th>
                      <th>الحساب</th>
                      <th>دينار</th>
                      <th>دولار</th>
                     
                    
                 </tr>
          </thead>

    <tbody>

    @foreach($credit as $payments)
    <tr>
    <th>{{$payments->wasl_number}}</th>
    <th>
    @if($payments->account_type==1) <span> طبيب <br> {{ $payments->doctor->name ??""}} </span> @endif
    @if($payments->account_type==2) <span> مريض <br> {{ $payments->Patient->name ??""}} </span> @endif
    @if($payments->account_type==3) <span> نقدي <br> {{ $payments->account_name ??""}} </span> @endif
    </th>
    <th>@convert($payments->amount_iqd)</th>
    <th>@convert($payments->amount_usd)</th>
   
    
    </tr>
    @endforeach
    
</tbody>

                </table>
            </div>
        </div>

      </div>
     
    </div>
  </div>

  


</body>

</html>