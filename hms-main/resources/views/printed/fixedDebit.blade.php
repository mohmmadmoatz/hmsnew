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
    $debitaccount = App\Models\FdebitCategory::find($id);

    $name = $debitaccount->name ?? "";


    $data = App\Models\FdebitTransaction::query();

    if($id != null){
        $data = $data->where('category_id', $id);
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
                  

                    <th>الفترة</th>
                    <th>تاريخ الطباعة</th>
                    
                </tr>
                <tr>
                    <th>
                        كشف حساب :  ({{$name ?? ""}})
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
                    <th>الحساب</th>
                    <th>التاريخ</th>
                    <th>المبلغ دينار</th>
                    <th>المبلغ دولار</th>
                    <th>الأسم</th>
                    <th>الملاحظات</th>
                    
                </tr>

                @foreach($data as $debittransaction)
                <tr>
                
                <td>
        <!-- Check if is checked or not  -->
      
       
      
        {{ $debittransaction->number }} 


    </td>
    <td>
        {{$debittransaction->category->name ??""}}
    </td>
    <td> {{ $debittransaction->date }} </td>
    <td> @convert($debittransaction->amount_iqd) </td>
    <td> @convert($debittransaction->amount_usd) </td>
    <td> {{ $debittransaction->name }} </td>
    <td> {{ $debittransaction->notes }} </td>
   
    

                </tr>
                @endforeach
              
                <!-- Sum of قبض و صرف  Seprated -->
               
               
        </table>

        <table class="table table-striped">

            @php
            $debit_sum_iqd = $data->sum('amount_iqd');
            $debit_sum_usd = $data->sum('amount_usd');
            
            
            
            
            @endphp

            <tr>
                <th>المجموع الكلي</th>
                <th>المبلغ دينار</th>
                <th>المبلغ دولار</th>
            </tr>
            <tr>
                <th></th>
                <!-- where payment type 1 -->
                <td>@convert($debit_sum_iqd)</td>
                <td>@convert($debit_sum_usd)</td>

            </tr>
            
             
              


        </table>

      </div>
     
    </div>
  </div>

  


</body>

</html>