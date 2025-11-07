<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>المدفوعات</title>
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

  .table-striped tbody tr:nth-of-type(odd) td {
    background-color: rgba(0,0,0,.05) !important;
}
.table-striped tbody tr:nth-of-type(odd) th {
    
    background-color: rgba(0,0,0,.05) !important;
}

</style>



<body dir="rtl">

    @php
    $report_name = "المدفوعات";
    $dates = $_GET['daterange'];

    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];
    $data = App\Models\Payments::where("payment_type",1)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"]);
   
    if(isset($_GET['payas'])){
      $payas = $_GET['payas'];

      if($payas == "doctor"){
      
        $report_name = "مدفوعات  الطبيب";
        
      $data = $data->where("doctor_id",$_GET['doctor_id'])
      ->get();
       

      }

      if($payas == "helper"){
        $report_name = "مدفوعات  مساعد جراح";
       
       $data = $data->where("account_name","مساعد جراح")
       ->get();
   
         }

         if($payas == "m5dr"){
          $report_name = "مدفوعات  المخدر";
       $data = $data->where("account_name","مخدر")
       ->get();
   
         }

         if($payas == "m5drhelper"){
          $report_name = "مدفوعات  مساعد مخدر";
       
       $data = $data->where("account_name","مساعد مخدر")
       ->get();
   
         }

         if($payas == "qabla"){
          $report_name = "مدفوعات القابلة";
       
       $data = $data->where("account_name","القابلة")
       ->get();
   
         }

         if($payas == "nurse"){
          $report_name = "مدفوعات الممرضة";
       
           $data = $data->where("account_name","ممرضة")
       ->get();
   
         }

         if($payas == "ambulance"){
          $report_name = "مدفوعات اسعاف طفل";
       
           $data = $data->where("account_name","اسعاف طفل")
       ->get();
   
         }

    }else{
      $data = $data->where(function ($query){
           $query->where("doctor_id","!=",0)
           ->orWhere("account_name","مخدر")
           ->orWhere("account_name","مساعد مخدر")
           ->orWhere("account_name","مساعد جراح")
           ->orWhere("account_name","القابلة")
           ->orWhere("account_name","ممرضة")
           ->orWhere("account_name","اسعاف طفل")
           ->orWhereNotNull("is_stage");
      })
    ->get();
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
                </tr>
                <tr>
                    <th>
                      {{$report_name}}
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
              <th>رقم الوصل</th>
              <th>التاريخ</th>
              <th>المستلم</th>
              <th>المبلغ</th>
              <th>العملية</th>
          </tr>
          </thead>
              
                @foreach($data as $item)
                <tr>
                    <td>{{$item->wasl_number}}</td>
                    <td style="width:110px">{{$item->date}}</td>
                 
                    <td>
                      @if($item->doctor_id)
                    {{$item->doctor->name ??""}}
                  @else
                  {{$item->account_name ??""}}

                  @endif
                    </td>
    
                    
                  
                  
                    <td>
                        @convert($item->amount_iqd) د.ع
                       /
                       @convert($item->amount_usd) $
                    </td>
                    <td>{{$item->description}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">المجموع</td>
                    <td style="font-weight: bold;">
                        @convert($data->sum("amount_iqd")) د.ع
                        / 
                        @convert($data->sum("amount_usd")) $
                    </td>
                    <td></td>
                </tr>
        </table>

     
     
    </div>
  </div>

  


</body>

</html>