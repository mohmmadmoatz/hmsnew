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
  
    $cat = $_GET['cat'] ?? "";

    $dates = $_GET['dates'];

$date1 = explode(" - ", $dates)[0];
$date2 = explode(" - ", $dates)[1];

    $exports =  App\Models\Warehouse::where("supplier_name",$cat)
    ->whereBetween("date",[$date1 . " 00:00:00",$date2 . " 23:59:59"])
    ->with("items")->get();
    
   $ids = array();
   $itemsarray = array();
    foreach($exports as $item){
        $x = $item->items;
        foreach($x as $sub){
            $itemsarray[] = $sub;
            $ids[] = $sub->product_id;
         
        }
    }

    $ids = array_unique($ids);
 

    $products = App\Models\Warehouseproduct::whereIn("id",$ids)->get();
    
    

    $itemscollection = collect($itemsarray);
  



   
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
                  
                    <th>القسم</th>
                    <th>الفترة</th>
                   
                    <th>تاريخ الطباعة</th>
                    
                </tr>
                <tr>
                    <th>
                       قوائم شركة 
                    </th>

                    <th>{{$cat ??""}}</th>
                    <th>{{$dates}}</th>
                    <th>
                        {{date("Y-m-d")}}
                    </th>
                
                </tr>
        </table>

        <hr>
        <table class="table table-bordered table-striped">
                <tr>
                    <th>المادة</th>
                 
                    <th>العدد</th>
                   
                    
                </tr>

             
                @foreach($products as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>
                      
                    {{$itemscollection->where("product_id",$item->id)->sum("qty")}}

                    {{$item->base->name ??""}}

                    </td>
                </tr>
                @endforeach
             
               
               
        </table>

      

      </div>
     
    </div>
  </div>

  


</body>

</html>