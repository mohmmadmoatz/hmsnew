<html lang="en" dir="rtl">
 @php
 $data = App\Models\Patient::find($_GET['id']);
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
    padding-top: 50px;
}

.card {
    box-shadow: 0 5px 5px 5px #e1e1e1;
    max-width: 350px;
    padding: 15px;
    border-radius: 5px;
    margin: auto;
    text-align: center;
}

img {
    width: 50%;
    border: 5px solid #e1e1e1;
    border-radius: 50%;
}

.social {
    margin: 15px 0;
}

a {
    font-size: 26px;
    padding: 7px 12px;
    text-decoration: none;
    color: #585858;
    border: 1px solid #e1e1e1;
    border-radius: 10px;
}

a:hover {
    background-color: #585858;
    color: #ffffff;
}
table, table tr td {
    width: 290px;
    margin: 0 auto;
    border: 1px solid #e1e1e1;
    text-align: center;
}
    </style>
    <title>
		Pateint Card
    </title>
</head>
 
<body>
    <div class="card">
        <div style="
        background: #E6659B;
        height: 100px;
        border-bottom-left-radius: 50px
    ">
        @if($data->image)
        <img src="{{asset('storage/'.$data->image)}}" alt="image" style="margin-top: 10px;width:100px ">
        @else
        <img src="avatar.png" alt="image" style="margin-top: 10px;width:100px ">
        @endif

    </div>
        <h1>{{$data->name}}</h1>
 
        <table>
          
            <tr>
                <td><strong>الجنس</strong></td>
                <td>{{$data->gender}}</td>
            </tr>
            <tr>
                <td><strong>العمر</strong></td>
                <td>{{$data->age}}</td>
            </tr>
           
            <tr>
                <td><strong>رقم الهاتف</strong></td>
                <td>{{$data->phone}}</td>
            </tr>

            <tr>
                <td><strong>التوجيه</strong></td>
                <td>
                    {{$data->stage->name ??""}}
                </td>
            </tr>

            <tr>
                <td><strong>اسم الطبيب/ة</strong></td>
                <td>
                    @php
                   
                    $doctor = App\Models\User::find($data->redirect_doctor_id);
                    @endphp
                    {{$doctor->name ??""}}
                </td>
            </tr>

        </table>

        <svg class="barcode"
  jsbarcode-value="{{$data->id}}"
  jsbarcode-height="40"
  jsbarcode-textmargin="0"
  jsbarcode-fontoptions="bold">
</svg>
     
    </div>
</body>
 <script src="{{asset('js/barcode.js')}}"></script>
 <script>
     JsBarcode(".barcode").init();

 </script>

<script>
    setTimeout(() => {
        window.print();
        window.close();
    }, 2000);
  </script>
</html>