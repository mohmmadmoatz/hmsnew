<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    $stage = App\Models\Stage::find($st);
    $dates = $_GET['daterange'];
    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];
    $doctorname = "";
    if(isset($_GET['doctor'])){
      $doctor = $_GET['doctor'];
      $doctorname = App\Models\User::find($doctor);
    }

    

    $data = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("redirect",$st);

    if($doctor){
      $data=$data->where("redirect_doctor_id",$doctor);
    }

    $data = $data->get();


    $iqd = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("redirect",$st);

    if($doctor){
      $iqd=$iqd->where("redirect_doctor_id",$doctor);
    }

    $iqd = $iqd->select(DB::raw('SUM(amount_iqd - return_iqd) as amount_iqd'))->first()->amount_iqd;;
   
    
    
    $usd = App\Models\Payments::where("payment_type",2)->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->where("redirect",$st);

    if($doctor){
      $usd=$usd->where("redirect_doctor_id",$doctor);
    }

    $usd = $usd->select(DB::raw('SUM(amount_usd - return_usd) as amount_usd'))->first()->amount_usd;

    // Daily breakdown
    $dailyData = [];
    $startDate = new DateTime($date1);
    $endDate = new DateTime($date2);
    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

    foreach ($dateRange as $date) {
        $currentDate = $date->format('Y-m-d');

        $dayPayments = App\Models\Payments::where("payment_type", 2)
            ->whereDate("date", $currentDate)
            ->where("redirect", $st);

        if ($doctor) {
            $dayPayments = $dayPayments->where("redirect_doctor_id", $doctor);
        }

        $dayPayments = $dayPayments->get();

        if ($dayPayments->count() > 0) {
            $dailyData[$currentDate] = [
                'payments' => $dayPayments,
                'total_iqd' => $dayPayments->sum('amount_iqd') - $dayPayments->sum('return_iqd'),
                'total_usd' => $dayPayments->sum('amount_usd') - $dayPayments->sum('return_usd'),
            ];
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
                     {{$stage->name}} - ({{$doctorname->name??""}})
                    </th>
                    <th>
                        {{$dates}}
                    </th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                    <th class="no-print">
                      @if($stage->doctor_price)
                      <a href="@route('expfromstage')?stage={{$stage->id}}&daterange={{$dates}}&type=doctor&doctor_id={{$doctor}}">كشف اجور الطبيب</a> /
                      @endif
                      @if($stage->other_price)
                      <a href="@route('expfromstage')?stage={{$stage->id}}&daterange={{$dates}}&type=nurse">كشف اجور الممرضة</a>
                      @endif
                    </th>
                </tr>
        </table>

        @if(count($dailyData) > 1)
        <div class="text-center my-3">
            <button id="toggleView" class="btn btn-primary no-print">
                <i class="fa fa-exchange"></i> عرض التقرير اليومي
            </button>
        </div>
        @endif

        <div id="detailedView">
            <hr>
            <h4>التفاصيل</h4>
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
                        <td>{{$item->date}}</td>
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
                            @convert($data->sum("amount_usd")) $



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

        @if(count($dailyData) > 1)
        <div id="dailyView" style="display: none;">
            <hr>
            <h4>التقرير اليومي</h4>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>التاريخ</th>
                  <th>عدد المعاملات</th>
                  <th>إجمالي المبلغ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dailyData as $date => $dayInfo)
                <tr>
                  <td>{{ $date }}</td>
                  <td>{{ count($dayInfo['payments']) }}</td>
                  <td style="font-weight: bold;">
                    @convert($dayInfo['total_iqd']) د.ع / @convert($dayInfo['total_usd']) $
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="2" style="font-weight: bold;">المجموع الكلي</td>
                  <td style="font-weight: bold;">
                    @convert($iqd) د.ع / @convert($usd) $
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
        @endif

        @if(count($dailyData) > 1)
        
        <div id="dailyReportSection" style="display: none;">
            <hr>
            <h4 style="text-align:right">التقرير اليومي</h4>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>التاريخ</th>
                  <th>عدد المعاملات</th>
                  <th>إجمالي المبلغ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dailyData as $date => $dayInfo)
                <tr>
                  <td>{{ $date }}</td>
                  <td>{{ count($dayInfo['payments']) }}</td>
                  <td style="font-weight: bold;">
                    @convert($dayInfo['total_iqd']) د.ع / @convert($dayInfo['total_usd']) $
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        @endif


    </div>
  </div>


<script>
$(document).ready(function() {
    $('#toggleView').click(function() {
        var $button = $(this);
        var $detailedView = $('#detailedView');
        var $dailyView = $('#dailyView');

        if ($detailedView.is(':visible')) {
            $detailedView.fadeOut(300, function() {
                $dailyView.fadeIn(300);
            });
            $button.html('<i class="fa fa-list"></i> عرض التفاصيل');
        } else {
            $dailyView.fadeOut(300, function() {
                $detailedView.fadeIn(300);
            });
            $button.html('<i class="fa fa-exchange"></i> عرض التقرير اليومي');
        }
    });
});
</script>


</body>

</html>