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
   
    $cash = $_GET['account'] ?? "";

    $data = App\Models\Payments::where("payment_type",1)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("doctor_id",0)

    ->where(function ($query){
    $query->where("account_name","!=","مخدر")
    ->where("account_name","!=","مساعد مخدر")
    ->where("account_name","!=","مساعد جراح")
    ->where("account_name","!=","القابلة")
    ->where("account_name","!=","ممرضة")
    ->where("account_name","!=","اسعاف طفل")
    ->orWhereNull("account_name");
        
})

    ->where("account_name",'LIKE','%'.$cash.'%')
    ->whereNull("is_stage")
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
                     المصاريف
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
    
                 @if($item->account_type==2) <span>  {{ $item->Patient->name ??""}} </span> @endif
    @if($item->account_type==3) <span>  {{ $item->account_name ??""}} </span> @endif
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