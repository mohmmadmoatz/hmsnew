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

  .table-striped tbody tr:nth-of-type(odd) th {
    background-color: rgba(0, 0, 0, .05)!important;
}

</style>



<body dir="rtl">

    @php
   
    $dates = $_GET['daterange'];

    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];

   // Old Amounts
    $sum_old_income_iqd = App\Models\Payments::where("date","<",$date1)->where("payment_type",2)->select(DB::raw('SUM(amount_iqd - return_iqd) as amount_iqd'))->first()->amount_iqd;
    $sum_old_income_usd = App\Models\Payments::where("date","<",$date1)->where("payment_type",2)->select(DB::raw('SUM(amount_usd - return_usd) as amount_usd'))->first()->amount_usd;

    $sum_old_outcome_iqd = App\Models\Payments::where("date","<",$date1)->where("payment_type",1)->sum("amount_iqd");
    $sum_old_outcome_usd = App\Models\Payments::where("date","<",$date1)->where("payment_type",1)->sum("amount_usd");
    // End Old Amounts

    // new Amounts

    $sum_income_iqd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",2)->select(DB::raw('SUM(amount_iqd - return_iqd) as amount_iqd'))->first()->amount_iqd;

    $sum_income_usd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",2)->select(DB::raw('SUM(amount_usd - return_usd) as amount_usd'))->first()->amount_usd;

    $sum_outcome_iqd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",1)
    ->where("doctor_id","=",0)
    ->where(function ($query){
    $query->where("account_name","!=","مخدر")
    ->where("account_name","!=","مساعد مخدر")
    ->where("account_name","!=","مساعد جراح")
    ->where("account_name","!=","القابلة")
    ->where("account_name","!=","ممرضة")
    ->where("account_name","!=","اسعاف طفل")
    ->orWhereNull("account_name");
        
})
    ->whereNull("is_stage")
    ->sum("amount_iqd");

    $sum_outcome_usd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",1)
    ->where("doctor_id","=",0)
    ->where(function ($query){
    $query->where("account_name","!=","مخدر")
    ->where("account_name","!=","مساعد مخدر")
    ->where("account_name","!=","مساعد جراح")
    ->where("account_name","!=","القابلة")
    ->where("account_name","!=","ممرضة")
    ->where("account_name","!=","اسعاف طفل")
    ->orWhereNull("account_name");
        
})
    ->whereNull("is_stage")
    ->sum("amount_usd");

    // End new Amounts


    // new Amounts

    $sum_paid_iqd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",1)
    ->where(function ($query){
           $query->where("doctor_id","!=",0)
           ->orWhere("account_name","مخدر")
           ->orWhere("account_name","مساعد مخدر")
           ->orWhere("account_name","مساعد جراح")
           ->orWhere("account_name","القابلة")
           ->orWhere("account_name","ممرضة")
           ->orWhere("account_name","اسعاف طفل")
           ->orWhereNotNull("is_stage");
      })
    ->sum("amount_iqd");

    $sum_paid_usd = App\Models\Payments::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("payment_type",1)
    ->where(function ($query){
           $query->where("doctor_id","!=",0)
           ->orWhere("account_name","مخدر")
           ->orWhere("account_name","مساعد مخدر")
           ->orWhere("account_name","مساعد جراح")
           ->orWhere("account_name","القابلة")
           ->orWhere("account_name","ممرضة")
           ->orWhere("account_name","اسعاف طفل")
           ->orWhereNotNull("is_stage");
      })
    ->sum("amount_usd");

    // End new Amounts

    $net_iqd = $sum_income_iqd - $sum_paid_iqd - $sum_outcome_iqd;
    $net_usd = $sum_income_usd - $sum_paid_usd - $sum_outcome_usd;

    $full_net_iqd = ($sum_old_income_iqd - $sum_old_outcome_iqd) +$net_iqd;
    $full_net_usd = ($sum_old_income_usd - $sum_old_outcome_usd) +$net_usd;

    @endphp

  <div class="py-2">
    <div class="container">
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
                </tr>
                <tr>
                    <th>
                        مصاريف واجور المستشفى
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
        <table class="table table-bordered table-striped">

          <thead>
                 <tr>
                      <th>التفاصيل</th>
                      <th>دينار</th>
                      <th>دولار</th>
                 </tr>
          </thead>

          <tbody>
                 <tr>
                      <th>المتراكم السابق</th>
                      <th>@convert($sum_old_income_iqd - $sum_old_outcome_iqd)</th>
                      <th>@convert($sum_old_income_usd - $sum_old_outcome_usd)</th>
                    
                 </tr>

               

                 <tr>
                      <th>
                        <a href="@route('income')?daterange={{$dates}}">

                        المقبوض لهذه اليوم (الفترة)

                        </a>
                        

                      </th>
                      <th>@convert($sum_income_iqd)</th>

                      <th>@convert($sum_income_usd)</th>

                 </tr>

                 <tr>
                      <th>
 <a href="@route('doctorpays')?daterange={{$dates}}">
 المدفوع لهذه اليوم (الفترة)

 </a>
                    
                    </th>
                      <th>@convert($sum_paid_iqd)</th>

                      <th>@convert($sum_paid_usd)</th>

                 </tr>

                 <tr>
                      <th>
                      <a href="@route('expense')?daterange={{$dates}}">المصاريف</a>

                      </th>
                      <th>@convert($sum_outcome_iqd)</th>

                      <th>@convert($sum_outcome_usd)</th>
                 </tr>
                 <tr>
                      <th>الصافي لهذه اليوم (الفترة)</th>
                      <th>@convert($net_iqd)</th>
                      <th>@convert($net_usd)</th>

                 </tr>

                 <tr>
                      <th>المسحوب</th>
                      <th>@convert(App\Models\Bank::sum("amount_iqd"))</th>
                      <th>@convert(App\Models\Bank::sum("amount_usd"))</th>
                      
                    
                 </tr>

                 <tr>
                      <th>الصافي لغاية هذه الفترة</th>
                      <th>@convert($full_net_iqd - App\Models\Bank::sum("amount_iqd"))</th>
                      <th>@convert($full_net_usd -  App\Models\Bank::sum("amount_usd"))</th>
                 </tr>
          </tbody>

    </table>

      </div>
     
    </div>
  </div>

  


</body>

</html>