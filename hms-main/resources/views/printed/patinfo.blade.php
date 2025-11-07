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
        </div>


        <div class="col-md-6">
          <h3  style="font-weight: bold;color: #e3006f">IN-PATIENT CASE SHEET</h3>
        </div>
        <div style="float: right;text-align: right;" class="col-md-6">
          <h3  style="font-weight: bold;color: #e3006f">استمارة المرضى الداخلين</h3>
        </div>
        <div class="col-md-12">
          <br>
        </div>

        <div class="col-md-12">
          <table class="table table-bordered" dir="rtl">
            <tr>
              <th class="thead">رقم الغرفة</th>
              <th class="input" colspan="7">{{$data->room->name ?? ""}}</th>
              
            </tr>
            <tr>
              <th class="thead">اسم المريض الرباعي</th>
              <th class="input" colspan="7">{{$data->name}}</th>
            </tr>
            <tr>
              <th class="thead">عنوان السكن</th>
              <th class="input" colspan="7">{{$data->adress ??""}}</th>
            </tr>
            <tr>
              <th class="thead">أسم الزوج/ة</th>
              <th class="input" colspan="7">{{$data->husbandname ??""}}</th>

            </tr>

            <tr>
              <th class="thead">أسم الأم الثلاثي</th>
              <th class="input">{{$data->mother ??""}}</th>
              <th class="thead">العمر</th>
              <th class="input" colspan="5">{{$data->age ??""}}</th>
            </tr>
            <tr>
              <th class="thead">المهنة</th>
              <th class="input">{{$data->job ??""}}</th>
              <th class="thead">الجنسية</th>
              <th class="input" colspan="5">{{$data->Nationality ??""}}</th>
            </tr>
            <tr>
              <th class="thead">رقم البطاقة الموحدة</th>
              <th class="input">{{$data->idSingle}}</th>
              <th class="thead">تاريخ الأنتهاء</th>
              <th class="input">{{$data->iddate}}</th>
              <th class="thead">جهة الأصدار</th>
              <th class="input" colspan="3">{{$data->idcreatejeha}}</th>
            </tr>

            <tr>
              <th class="thead">السجل المدني</th>
              <th class="input">{{$data->identity_book}}</th>
              <th class="thead">الدائرة</th>
              <th class="input">{{$data->identity_circule}}</th>
              <th class="thead">رقم الصحيفة</th>
              <th class="input">{{$data->identity_page}}</th>
              <th class="thead">رقم الهوية</th>
              <th class="input">{{$data->identity_number}}</th>
            </tr>

            <tr>
              <th class="thead">أقرب شخص له</th>
              <th class="input">{{$data->relaitve_name}}</th>
              <th class="thead">عنوانه والهاتف</th>
              <th class="input" colspan="5">{{$data->relaitve_phone}}</th>
            </tr>

            <tr>
              <th class="thead">الطبيب المعالج</th>
              <th class="input" >{{$data->doctor->name ??""}}</th>
              <th class="thead">نوع العملية</th>
              <th class="input" colspan="5">{{$data->operation->name ?? ""}}</th>
            </tr>
           
            <tr>
              <th class="thead">تاريخ الدخول</th>
              <th class="input">{{$data->inter_at}}</th>
              <th class="thead">تاريخ الخروج</th>
              <th class="input" colspan="5"></th>
            </tr>

          </table>
        </div>

       

      </div>

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