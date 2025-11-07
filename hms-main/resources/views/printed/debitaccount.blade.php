<!DOCTYPE html>
<html>
<head>
  <title>كشف حساب</title>
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
    $id = $_GET['id'];
    $debitaccount = App\Models\DebitAccount::find($id);
    $name = $debitaccount->name;
    $data = App\Models\DebitTransaction::query();

    if($id != null){
        $data = $data->where('account_id', $id);
    }

    if($dates != null){
        $dates = explode(' - ', $dates);
        $data = $data->whereBetween('date', [$dates[0], $dates[1]]);
    }
    
    $data = $data->get();

    $dates = $_GET['daterange'];


   
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
                    <th>كشف</th>
                    <th>الدين</th>

                    <th>الفترة</th>
                    <th>تاريخ الطباعة</th>
                    
                </tr>
                <tr>
                    <th>
                        كشف حساب :  ({{$name ?? ""}})
                    </th>
                    <th>
                        {{$debitaccount->balance}}
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
                <tr>
                    <th>رقم القائمة</th>
                    <th>التاريخ</th>
                    <th>المبلغ دينار</th>
                    <th>المبلغ دولار</th>
                    <th>الأسم</th>
                    <th>الملاحظات</th>
                    <th>الحركة</th>
                </tr>

                @foreach($data as $debittransaction)
                <tr>
                
                <td>
        <!-- Check if is checked or not  -->
      
        @if($debittransaction->payment_type == 2 && $debittransaction->checked == 1)
            <i class = "fa fa-check"></i>
           
        @endif
      
        {{ $debittransaction->number }} 


    </td>
    <td> {{ $debittransaction->date }} </td>
    <td> @convert($debittransaction->amount_iqd) </td>
    <td> @convert($debittransaction->amount_usd) </td>
    <td> {{ $debittransaction->name }} </td>
    <td> {{ $debittransaction->notes }} </td>
    <td> 
        @if($debittransaction->payment_type == 1)
        <span style="font-size:15px" class="badge badge-success">صرف</span>
            
        @elseif($debittransaction->payment_type == 2)
        <span style="font-size:15px" class="badge badge-danger">قبض</span>
           
        @endif
      

                
  

    </td>
    

                </tr>
                @endforeach
              
                <!-- Sum of قبض و صرف  Seprated -->
               
               
        </table>

        <table class="table table-striped">

            @php
            $debit_sum_iqd = $data->where('payment_type', 1)->sum('amount_iqd');
            $debit_sum_usd = $data->where('payment_type', 1)->sum('amount_usd');
            
            $credit_sum_iqd = $data->where('payment_type', 2)->sum('amount_iqd');
            $credit_sum_usd = $data->where('payment_type', 2)->sum('amount_usd');

         
            $remaining_balance_iqd =  $credit_sum_iqd -  $debit_sum_iqd;
            $remaining_balance_usd =  $credit_sum_usd -  $debit_sum_usd;
            
            
            @endphp

            <tr>
                <th>المجموع الكلي</th>
                <th>المبلغ دينار</th>
                <th>المبلغ دولار</th>
            </tr>
            <tr>
                <td>الصرف</td>
                <!-- where payment type 1 -->
                <td>@convert($debit_sum_iqd)</td>
                <td>@convert($debit_sum_usd)</td>

            </tr>
            <tr>
                <td>القبض</td>
                <!-- where payment type 2 -->
                <td>@convert($credit_sum_iqd)</td>
                <td>@convert($credit_sum_usd)</td>
                </tr>
            
                <tr>
                    <td>المتبقي</td>
                    <td style="font-weight:bold">@convert($remaining_balance_iqd)</td>
                    <td style="font-weight:bold">@convert($remaining_balance_usd)</td>

                </tr>
             
              


        </table>

      </div>
     
    </div>
  </div>

  


</body>

</html>