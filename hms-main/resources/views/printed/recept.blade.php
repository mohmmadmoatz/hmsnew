<html lang="en" dir="rtl">
 @php
 $data = App\Models\Payments::find($_GET['id']);
 @endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        @font-face {
  font-family: tajwal;
  src: url({{asset('css/Tajawal-Regular.ttf')}});
}
    body {
    font-family: tajwal;
    margin: 0;
}
@page {
    margin: 0;
}
</style>
    <title>
		Pateint Card
    </title>
</head>
 
<body>

<img src="{{asset('formimages/hmslogo.png')}}" width="98%" style="

opacity: 0.1;
top: 40%;
left: 0;
bottom: 0;
right: 0;
position: absolute;
z-index: -1;

"> 

@if($data->payment_type==2)
<img src="{{asset('formimages/headerrecept.png')}}" width="98%" alt="" srcset=""> 
@endif

@if($data->payment_type==1)
<img src="{{asset('formimages/headerrecept2.png')}}" width="98%" alt="" srcset=""> 
@endif

<div style="display:inline-flex">
    
    <div style="color:3ba8b1;font-weight:bold;height: 35px;width:200px;border: 1px solid;border-color: 3ba8b1;margin: 20px;font-size: 25px;text-align: center;">
       @convert($data->amount_iqd)
    </div>
    <h3 style="margin-top: 20px;font-size: 25px;color:3ba8b1;font-weight: bold;">دينار</h3>


    <div style="color:e2177a;font-weight:bold;height: 35px;width:200px;border: 1px solid;border-color: e2177a;margin: 20px;font-size: 25px;text-align: center;">
       @convert($data->amount_usd)
        
    </div>
    <h3 style="margin-top: 20px;font-size: 25px;color:e2177a;font-weight: bold;">دولار</h3>


</div>

<div style="margin-left: 20px;margin-right: 20px;">
    <table class="table" style="width: 100%;">
        <tbody><tr>
            <th style="text-align: right;">
                <span style="color:3ba8b1">التاريخ : {{$data->date}}</span>
            </th>
            <th style="text-align: left;">
                <span dir="ltr" style="color:3ba8b1;margin-left: 80px;font-size: 25px;">No: {{$data->wasl_number}}</span>
            </th>
        </tr>
    </tbody></table>


</div>

<div style="margin-left: 20px;margin-right: 20px;">
    <table class="table">
        <tr>
            <th style="text-align: right;">
            @if($data->payment_type==2)
                <h3 style="color:3ba8b1">استلمت من :</h3>
            @endif

            @if($data->payment_type==1)
                <h3 style="color:3ba8b1">دفع للسيد/ة :</h3>
            @endif
            

            </th>
            <th style="
    /* border-bottom: 1px solid; */
">               
@if($data->patinet_id && $data->account_type ==2)

                <h3 dir="ltr" style="color:3ba8b1;border-bottom: 1px dotted;width: 580px;text-align: right;">{{$data->Patient->name}}</h3>
                @endif

                @if($data->doctor)
                <h3 dir="ltr" style="color:3ba8b1;border-bottom: 1px dotted;width: 580px;text-align: right;">{{$data->doctor->name}}</h3>
                @endif

                 @if($data->account_name)
                <h3 dir="ltr" style="color:3ba8b1;border-bottom: 1px dotted;width: 580px;text-align: right;">{{$data->account_name}}</h3>
                @endif

            </th>
        </tr>
    </table>
</div>

<div style="margin-left: 20px;margin-right: 20px;">
    <table class="table">
        <tr>
            <th style="text-align: right;">
                <h3 style="color:3ba8b1">مبلغ وقدره :</h3>
            </th>
            <th style="
    /* border-bottom: 1px solid; */
">
                <h3 id="amountWrite" dir="ltr" style="color:3ba8b1;border-bottom: 1px dotted;width: 580px;text-align: right;"></h3>
            </th>
        </tr>
    </table>
</div>

<div style="margin-left: 20px;margin-right: 20px;">
    <table class="table">
        <tr>
            <th style="text-align: right;">
                <h3 style="color:3ba8b1">الملاحظات :</h3>
            </th>
            <th style="
    /* border-bottom: 1px solid; */
">
                <h3 dir="ltr" style="color:3ba8b1;border-bottom: 1px dotted;width: 580px;text-align: right;">{{$data->description}}</h3>
            </th>
        </tr>
    </table>
</div>
<img src="{{asset('formimages/receptfotter1.png')}}" width="98%" alt="" srcset=""> 


</body>
 <script src="{{asset('js/tafqit.js')}}"></script>
 <script>

        var usd = "{{$data->amount_usd}}";
        if(!usd){
            usd =0;
        }

        var iqd = "{{$data->amount_iqd}}";
        if(!iqd){
            iqd =0;
        }

        var amount = document.getElementById("amountWrite");
        var amountWrite = tafqit(iqd,{TextToFollow:"on"}) + " دينار فقط لاغير ";
        amountWrite += " و " + tafqit(usd,{TextToFollow:"on"}) + " دولار فقط لاغير ";
        amount.innerHTML = amountWrite
        
        setTimeout(() => {
            window.print()
            window.close()
        }, 1500);

 </script>
</html>