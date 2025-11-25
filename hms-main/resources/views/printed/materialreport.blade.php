<!DOCTYPE html>
<html>
<head>
  <title>كشف حسب المادة</title>
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

    $product_id = $_GET['product'] ?? "";

    $dates = $_GET['dates'];

    $date1 = explode(" - ", $dates)[0];
    $date2 = explode(" - ", $dates)[1];

    // Get the selected product
    $product = App\Models\Warehouseproduct::find($product_id);

    // Get all department names that requested this product in the date range
    $departmentNames = App\Models\WarehouseExport::whereBetween("date", [$date1 . " 00:00:00", $date2 . " 23:59:59"])
        ->whereHas("items", function($query) use ($product_id) {
            $query->where("product_id", $product_id);
        })
        ->distinct()
        ->pluck("name")
        ->toArray();

    // Get department details
    $departments = App\Models\Stocksup::whereIn("name", $departmentNames)->where("type", "قسم")->get();

    // Calculate totals for each department
    $departmentTotals = [];
    $grandTotal = 0;

    foreach($departments as $department) {
        $exports = App\Models\WarehouseExport::where("name", $department->name)
            ->whereBetween("date", [$date1 . " 00:00:00", $date2 . " 23:59:59"])
            ->with(["items" => function($query) use ($product_id) {
                $query->where("product_id", $product_id);
            }])
            ->get();

        $totalQty = 0;
        foreach($exports as $export) {
            foreach($export->items as $item) {
                $totalQty += $item->qty;
            }
        }
        $departmentTotals[$department->id] = $totalQty;
        $grandTotal += $totalQty;
    }

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
                    <th>كشف حسب المادة</th>

                    <th>المادة</th>
                    <th>الفترة</th>

                    <th>تاريخ الطباعة</th>

                </tr>
                <tr>
                    <th>
                       طلبات مخزن حسب المادة
                    </th>

                    <th>{{$product ? $product->name : ''}}</th>
                    <th>{{$dates}}</th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>

                </tr>
        </table>

        <hr>
        <table class="table table-bordered table-striped">
                <tr>
                    <th>القسم</th>

                    <th>الكمية</th>


                </tr>


                @foreach($departments as $department)
                <tr>
                    <td>{{$department->name}}</td>
                    <td>
                        {{$departmentTotals[$department->id]}}
                    </td>
                </tr>
                @endforeach

                <tr class="">
                    <td><strong>الإجمالي</strong></td>
                    <td><strong style="color: purple;font-size: 1.5rem;">{{$grandTotal}}</strong></td>
                </tr>


        </table>



      </div>

    </div>
  </div>



</body>

</html>
