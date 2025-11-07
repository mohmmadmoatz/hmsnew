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

</style>

<style>
  .formFil {
   border-bottom: 2px solid;
    padding-bottom: 5px;
  }

  .thead {
    color: #e3006f !important;
    font-weight: normal;
    
  }

  .input {
    color: #32a7b0;
    font-weight: normal;

  }
 
  .table-bordered th, .table-bordered td {
border: 4px solid #dee2e6;
}

  table {
    text-align: right;
  }
</style>

<body>

    @php
    $id = $_GET['id'];
    $data = App\Models\Patient::find($id);
    @endphp

  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12" align="center">
          <img  src="{{asset('formimages/hmslogo.png')}}" width="50%">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <hr>
          <h4>المريض :    
              {{$data->name}}
          </h4>
        </div>

 
      @if(App\Models\FollowUp::where("pat_id",$data->id)->count()==0)
      <img width="100%" height="100%" src="formimages/img1.jpg" alt="" srcset="">
      @endif

    
      

      
      @if(App\Models\FollowUp::where("pat_id",$data->id)->count() > 0)
     <table width="100%">
       <tr>
         <th style="text-align:left"> <h2 style="color: #e3006f;
       font-weight: bold;">FollowUp -Charts</h2></th>
       <th style="text-align:right"> <h2 style="color: #e3006f;
       font-weight: bold;">ملاحظات الممرضة والعلاج</h2></th>
       </tr>
     </table>

     <table class="table table-bordered">

     <tr>
       <thead>
         <th class="thead">B.P</th>
         <th class="thead">P.R</th>
         <th class="thead">Drain</th>
         <th class="thead">I.Take</th>
         <th class="thead">Out.put</th>
         <th class="thead">Spo2</th>
         <th class="thead">Temp</th>
         <th class="thead">اسم الممرضة</th>
         <th class="thead">العلاج</th>
         <th class="thead">التاريخ والوقت</th>
       </thead>
     </tr>

     @foreach(App\Models\FollowUp::where("pat_id",$data->id)->get() as $item)
      <tr>
      <th class="input">{{$item->bp}}</th>
         <th class="input">{{$item->pr}}</th>
         <th class="input">{{$item->drain}}</th>
         <th class="input">{{$item->itake}}</th>
         <th class="input">{{$item->output}}</th>
         <th class="input">{{$item->spo2}}</th>
         <th class="input">{{$item->Temp}}</th>
         <th class="input">{{$item->user->name}}</th>
         <th class="input">{{$item->treatment}}</th>
         <th class="input">{{$item->created_at}}</th>
      </tr>
      @endforeach
     </table>
     @endif

     
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  
  <script>
    setTimeout(() => {
        window.print();
    //    window.close();
    }, 2000);
  </script>

</body>

</html>