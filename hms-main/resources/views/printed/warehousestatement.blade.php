<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
  <style>
    @font-face { font-family: tajwal; src: url({{asset('css/Tajawal-Regular.ttf')}}); }
    body { font-family: tajwal; font-size: 14px; line-height: 1.5; color: #000000; }
    h3, h4, h5 { font-family: tajwal !important; margin: 10px 0; color: #000000; }
    table { text-align: right; font-size: 12px; margin-bottom: 15px; border-collapse: collapse; width: 100%; color: #000000; }
    th, td { padding: 8px 10px; border: 2px solid #333333; color: #000000; }
    th { background: #f8f9fa; font-weight: bold; border: 2px solid #333333; }
    .supplier-card { border: 3px solid #333333; margin-bottom: 20px; padding: 15px; border-radius: 5px; background: white; }
    .supplier-header { background: #f8f9fa; padding: 12px; margin: -15px -15px 15px -15px; border-radius: 5px 5px 0 0; border-bottom: 2px solid #333333; color: #000000; }
    .stats-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: bold; font-size: 14px; color: #000000; }
    .stats-row span { flex: 1; text-align: center; padding: 8px; background: #f8f9fa; margin: 0 2px; border-radius: 3px; border: 2px solid #333333; color: #000000; }
    .paid-table { border-left: 6px solid #28a745; border: 2px solid #333333; border-left: 6px solid #28a745; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .unpaid-table { border-left: 6px solid #dc3545; border: 2px solid #333333; border-left: 6px solid #dc3545; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .table-summary { background: #e9ecef; font-weight: bold; border: 2px solid #333333; color: #000000; }
    .btn-pay { background: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 2px solid #1e7e34; }
    .btn-pay:hover { background: #218838; }
    .no-data { text-align: center; padding: 30px; color: #000000; font-size: 16px; border: 2px solid #333333; border-radius: 5px; }

    /* Ensure all text is black */
    * { color: #000000; }
    a { color: #0000ff; }
    a:hover { color: #0000cc; }

    /* Hide buttons when printing */
    @media print {
      .btn-pay { display: none !important; }
      .supplier-card { page-break-inside: avoid; }
      body { font-size: 12px; }
      .supplier-card { margin-bottom: 10px; }
      .supplier-card, table, th, td { border-color: #000000 !important; }
    }
  </style>
</head>

<body dir="rtl">
@php
$dates = $_GET['daterange'];
$date1 = explode(" - ", $dates)[0];
$date2 = explode(" - ", $dates)[1];
    $warehouses = App\Models\Warehouse::whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])->orderBy('supplier_name')->get();
    $suppliers = $warehouses->groupBy('supplier_name');

    // Calculate totals
    $totalPaid = $warehouses->where('paid', true)->sum('total');
    $totalUnpaid = $warehouses->where('paid', false)->sum('total');
    $grandTotal = $warehouses->sum('total');
@endphp

<div class="container-fluid" style="padding: 20px;">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12 text-center">
      <img src="{{asset('formimages/hmslogo.png')}}" width="200px" style="margin-bottom: 15px;">
      <h3 style="color: #000000; border-bottom: 3px solid #000000; padding-bottom: 10px; display: inline-block;">كشف حسابات المخزن</h3>
    </div>
  </div>

  <!-- Report Info -->
  <div class="row mb-4">
    <div class="col-12">
      <table class="table table-bordered" style="background: #f8f9fa; border: 3px solid #000000;">
        <tr>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">الفترة الزمنية</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">تاريخ التقرير</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">عدد الموردين</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">إجمالي القوائم</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">إجمالي المدفوع</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">إجمالي المتبقي</th>
          <th width="14%" style="border: 3px solid #000000; color: #000000;">المبلغ الإجمالي</th>
        </tr>
        <tr>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">{{$dates}}</td>
          <td style="border: 3px solid #000000; color: #000000;">{{date("Y-m-d")}}</td>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">{{$suppliers->count()}}</td>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">{{$warehouses->count()}}</td>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">@convert($totalPaid)</td>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">@convert($totalUnpaid)</td>
          <td style="font-weight: bold; border: 3px solid #000000; color: #000000; background: #e9ecef;">@convert($grandTotal)</td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Suppliers -->
  @foreach($suppliers as $supplierName => $supplierWarehouses)
  @php
  $totalAmount = $supplierWarehouses->sum('total');
  $paidWarehouses = $supplierWarehouses->where('paid', true);
  $unpaidWarehouses = $supplierWarehouses->where('paid', false);
  $paidAmount = $paidWarehouses->sum('total');
  $unpaidAmount = $unpaidWarehouses->sum('total');
  $remainingAmount = $totalAmount - $paidAmount;
  @endphp

  <div class="supplier-card">
    <div class="supplier-header text-right" style="border-bottom: 3px solid #000000;">
      <h4 style="margin: 0; color: #000000; font-weight: bold;">{{ $supplierName }}</h4>
    </div>

    <div class="stats-row">
      <span style="background: #e3f2fd; border: 3px solid #000000; color: #000000;">
        إجمالي المبلغ<br><strong style="font-size: 16px; color: #000000;">@convert($totalAmount)</strong>
      </span>
      <span style="background: #e8f5e8; border: 3px solid #000000; color: #000000;">
        المبلغ المدفوع<br><strong style="font-size: 16px; color: #000000;">@convert($paidAmount)</strong>
      </span>
      <span style="background: #ffebee; border: 3px solid #000000; color: #000000;">
        المبلغ المتبقي<br><strong style="font-size: 16px; color: #000000;">@convert($remainingAmount)</strong>
      </span>
    </div>

    <div class="row">
      <!-- Paid Warehouses -->
      @if($paidWarehouses->count() > 0)
      <div class="col-6" style="padding-left: 5px;">
        <table class="table paid-table" style="border: 3px solid #000000;">
          <thead style="background: #e8f5e8; color: #000000; border: 3px solid #000000;">
            <tr><th colspan="3" style="border: 3px solid #000000; color: #000000;"><i class="fa fa-check-circle"></i> القوائم المدفوعة ({{$paidWarehouses->count()}})</th></tr>
            <tr><th style="border: 3px solid #000000; color: #000000;">رقم القائمة</th><th style="border: 3px solid #000000; color: #000000;">تاريخ الإدخال</th><th style="border: 3px solid #000000; color: #000000;">المبلغ</th></tr>
          </thead>
          <tbody>
            @foreach($paidWarehouses as $warehouse)
            <tr style="border: 3px solid #000000;">
              <td style="border: 3px solid #000000; color: #000000;"><a href="{{asset('storage/'.$warehouse->image)}}" target="_blank" style="color: #0000ff;">{{$warehouse->menu_no}}</a></td>
              <td style="border: 3px solid #000000; color: #000000;">{{$warehouse->date}}</td>
              <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">@convert($warehouse->total)</td>
            </tr>
            @endforeach
            <tr class="table-summary" style="background: #c8e6c9; border: 3px solid #000000;"><td colspan="2" style="border: 3px solid #000000; color: #000000;"><strong>المجموع المدفوع</strong></td><td style="border: 3px solid #000000; color: #000000;"><strong>@convert($paidAmount)</strong></td></tr>
          </tbody>
        </table>
      </div>
      @endif

      <!-- Unpaid Warehouses -->
      @if($unpaidWarehouses->count() > 0)
      <div class="col-{{ $paidWarehouses->count() > 0 ? '6' : '12' }}" style="padding-right: 5px;">
        <table class="table unpaid-table" style="border: 3px solid #000000;">
          <thead style="background: #ffebee; color: #000000; border: 3px solid #000000;">
            <tr><th colspan="3" style="border: 3px solid #000000; color: #000000;"><i class="fa fa-exclamation-triangle"></i> القوائم غير المدفوعة ({{$unpaidWarehouses->count()}})</th></tr>
            <tr><th style="border: 3px solid #000000; color: #000000;">رقم القائمة</th><th style="border: 3px solid #000000; color: #000000;">تاريخ الإدخال</th><th style="border: 3px solid #000000; color: #000000;">المبلغ</th></tr>
          </thead>
          <tbody>
            @foreach($unpaidWarehouses as $warehouse)
            <tr style="border: 3px solid #000000;">
              <td style="border: 3px solid #000000; color: #000000;"><a href="{{asset('storage/'.$warehouse->image)}}" target="_blank" style="color: #0000ff;">{{$warehouse->menu_no}}</a></td>
              <td style="border: 3px solid #000000; color: #000000;">{{$warehouse->date}}</td>
              <td style="font-weight: bold; border: 3px solid #000000; color: #000000;">@convert($warehouse->total)</td>
            </tr>
            @endforeach
            <tr class="table-summary" style="background: #ffcdd2; border: 3px solid #000000;"><td colspan="2" style="border: 3px solid #000000; color: #000000;"><strong>المجموع المتبقي</strong></td><td style="border: 3px solid #000000; color: #000000;"><strong>@convert($unpaidAmount)</strong></td></tr>
          </tbody>
        </table>

        @if($unpaidAmount > 0)
        <div class="text-center" style="margin-top: 15px;">
          <a href="@route(getRouteName().'.payments.create')?payment_type=1&account_type=4&supplier_names[]={{urlencode($supplierName)}}&daterange={{$dates}}&amount_iqd={{$unpaidAmount}}"
             target="_blank" class="btn-pay">
            <i class="fa fa-credit-card"></i> دفع المبلغ المتبقي (@convert($unpaidAmount) د.ع)
          </a>
        </div>
        @endif
      </div>
      @endif
    </div>
  </div>
  @endforeach

  @if($suppliers->count() == 0)
  <div class="no-data" style="border: 1px solid #ddd; border-radius: 5px; margin: 20px 0;">
    <i class="fa fa-info-circle fa-3x mb-3" style="color: #6c757d;"></i>
    <h5 style="color: #6c757d; margin: 0;">لا توجد قوائم مخزن في الفترة المحددة</h5>
    <p style="color: #6c757d; margin-top: 10px;">يرجى التأكد من تحديد فترة زمنية صحيحة</p>
  </div>
  @endif
</div>

</body>
</html>
