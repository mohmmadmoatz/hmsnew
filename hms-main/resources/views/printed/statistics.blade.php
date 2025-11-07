<!DOCTYPE html>
<html dir="rtl">
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

@media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}

</style>



<body dir="rtl">

    @php
   
    $dates = $_GET['daterange'];

   

    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];

    

    $operations = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("operation_name","!=","ولادة طبيعية")
    ->where("operation_name","!=","ولادة قيصرية");

    $opCount = $operations->count();
    $opSum = $operations->sum("operation_price") - $operations->sum("doctorexp");
    
    $borns = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where(function($query){
     $query->where('operation_name', "ولادة طبيعية")
    ->orWhere('operation_name', "ولادة قيصرية");
    });
    

    $bornsCount = $borns->count();
    $bornsSum = $borns->sum("operation_price") - $borns->sum("doctorexp");

    
    $hosOperation = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("nsba","<",60)
    ->where("operation_name","!=","ولادة طبيعية")
    ->where("operation_name","!=","ولادة قيصرية")
    ->count();

    $doctorOperation = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("nsba",">=",60)
    ->where("operation_name","!=","ولادة طبيعية")
    ->where("operation_name","!=","ولادة قيصرية")
    ->count();


    $hosBorns = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("nsba","<",60)

    ->where(function($query){
     $query->where('operation_name', "ولادة طبيعية")
    ->orWhere('operation_name', "ولادة قيصرية");
    })

    ->count();

    $doctorBorns = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("nsba",">=",60)
    ->where(function($query){
     $query->where('operation_name', "ولادة طبيعية")
    ->orWhere('operation_name', "ولادة قيصرية");
    })
    ->count();



    
    $allOp = App\Models\OperationHold::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])->groupBy("operation_name")
    ->select('operation_name',
     DB::raw('count(*) as count'),
     DB::raw('sum(operation_price - doctorexp) as total'),
    )
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
                       كشف احصائيات العمليات
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

        <div class="col-md-12">
        <h4 align="center">
            العمليات والولادات
        </h4>

        <table class="table table-bordered table-striped">
            <tr>
                <th>العمليات</th>
                <th>العدد : {{$opCount}} </th>
                <th>المبلغ : @convert($opSum)</th>
            </tr>
            <tr>
                <th>الولادات</th>
                <th>العدد : {{$bornsCount}} </th>
                <th>المبلغ : @convert($bornsSum)</th>
            </tr>
        </table>

        <table class="table table-bordered table-striped">
            <tr>
                <th>عدد عمليات مرضى المستشفى</th>
                <th>عدد عمليات مرضى الأطباء</th>
                
            </tr>
            <tr>
                <th>
                    <span style="font-size:40px;color:red">{{$hosOperation}}</span>
                </th>
                <th>
                <span style="font-size:40px;color:red">{{$doctorOperation}}</span>

                </th>
               
            </tr>
        </table>

        <table class="table table-bordered table-striped">
            <tr>
                <th>عدد ولادات مرضى المستشفى</th>
                <th>عدد ولادات مرضى الأطباء</th>
                
            </tr>
            <tr>
                <th>
                    <span style="font-size:40px;color:red">{{$hosBorns}}</span>
                </th>
                <th>
                <span style="font-size:40px;color:red">{{$doctorBorns}}</span>

                </th>
               
            </tr>
        </table>

        <h5 align="center">كشف مفصل</h5>

        <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>
                العملية
            </th>
            <th>العدد</th>
            <th>المبلغ</th>
        </tr>
        </thead>

        @foreach($allOp as $item)

        <tr>
            <td>
                {{$item->operation_name}}
            </td>
            <td>
                {{$item->count}}
            
            </td>
            
            <td>
                @convert($item->total)
            </td>
        </tr>
        @endforeach

        </table>

        <hr>

        <div class="col-md-12" align="right">
            <h4>صافي الاقسام للفترة  : {{$dates}}</h4>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>القسم</th>
                    <th>العدد</th>
                    <th>نسبة الطبيب</th>
                    <th>نسبة المستشفى</th>
                </tr>
                
            </thead>
            <tbody>
                @foreach(App\Models\Stage::get() as $item)
                @php
                $payments = App\Models\Payments::
                whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
                ->where("redirect",$item->id);
                @endphp
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$payments->count()}}</td>
                    <td>
                      
                        @convert( $payments->sum("redirect_doctor_price"))
                    </td>
                    <td>
                      
                        @convert( $payments->sum("amount_iqd")) د.ع /
                        @convert( $payments->sum("amount_usd")) $
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <h4 align="center">الناتج النهائي</h4>

        <table class="table table-bordered table-striped">
            @php
            $payments = App\Models\Payments::
                whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"]);

                $payments2 = App\Models\Payments::
                whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"]);

                $income_iqd = $payments->where("payment_type",2)->sum("amount_iqd");
                $income_usd = $payments->where("payment_type",2)->sum("amount_usd");

                $exp_iqd = $payments2->where("payment_type",1)->sum("amount_iqd");
                $exp_usd = $payments2->where("payment_type",1)->sum("amount_usd");

            @endphp
         
                <tr>
                    <th> مجموع القبض الكلي </th>
                    <th>
                       @convert($income_iqd) دينار عراقي
                    </th>
                    <th>
                       @convert($income_usd) دولار امريكي
                    </th>
                </tr>
                <tr>
                    <th> مجموع الصرف الكلي </th>
                    <th>
                       @convert($exp_iqd) دينار عراقي
                    </th>
                    <th>
                       @convert($exp_usd) دولار امريكي
                    </th>
                </tr>

                <tr>
                    <th>  الموجود النقدي للفترة </th>
                    <th>
                       @convert($income_iqd - $exp_iqd) دينار عراقي
                    </th>
                    <th>
                       @convert($income_usd - $exp_usd) دولار امريكي
                    </th>
                </tr>
            
        </table>

        </div>
      
     
    </div>
  </div>

  


</body>

</html>