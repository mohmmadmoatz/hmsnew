<!DOCTYPE html>
<html>
<head>
  <title>طباعة فحوصات مختبر</title>
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
    font-size:22px;

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

  

 .table-striped tbody tr:nth-of-type(odd) th {
    background-color: rgba(0, 0, 0, .05)!important;
}




@media print {
  #spacer {height: 2em;} /* height of footer + a little extra */
  #footer {
    position: fixed;
    bottom: 0;
  }
  .no-print {
    display: none !important;
  }
}

</style>


@php

$id = $_GET['id'];
$lab = App\Models\Lab::find($id);
$tests = App\Models\PatTests::where("lab_id",$lab->id)->get();

$testSameCategory = $tests->groupBy('category_id');
//dd($testSameCategory);

// Collect components data for sharing
$componentsData = $tests->map(function($test) {
    return App\Models\PatTestComponet::where("pat_test_id", $test->id)->with('componet')->get()->toArray();
})->toArray();

@endphp

<body>


@foreach($testSameCategory as $item)
  <div class="py-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12" align="center">
          <img  src="{{asset('headerimage.png')}}?changed=1" width="100%">
        </div>
      </div>

      <div class="row py-2 no-print">
        <div class="col-md-12" align="center">
          <button id="shareBtn" class="btn btn-primary" onclick="shareLabTest()">
            <i class="fa fa-share"></i> مشاركة التقرير
          </button>
          <div id="shareUrlContainer" style="display: none; margin-top: 10px;">
            <div class="alert alert-success">
              <strong>رابط المشاركة:</strong>
              <input type="text" id="shareUrlInput" readonly style="width: 100%; margin-top: 5px; padding: 5px;" />
              <button class="btn btn-sm btn-secondary" onclick="copyShareUrl()" style="margin-top: 5px;">
                <i class="fa fa-copy"></i> نسخ الرابط
              </button>
            </div>
          </div>
        </div>
      </div>



      <div class="row py-3">
        <table class="table table-bordered table-striped" style="text-align:left">
               <tr>
                   <th>Name: <span style="float:right"> {{$lab->patient->name}} </span> </th>
                   <th>Age:  <span style="float:right"> {{$lab->patient->age}} </span> </th>
              
               </tr>
               <tr>
                   <th>Consultant:</th>
                   <th>Date: {{$lab->created_at->format("Y-m-d")}} </th>
                  
               </tr>
               <tr>
                   <th>Sample Time:</th>
                   <th>Report time:</th>
                   
               </tr>

               @if($lab->reference)
               <tr>
                <th>Reference</th>
                <th>{{$lab->reference}}</th>
               </tr>
               @endif

               <tr>
                <th>Barcode</th>
                <th> <svg class="barcode"
  jsbarcode-value="GS-{{$lab->id}}"
  jsbarcode-height="40"
  jsbarcode-textmargin="0"
  jsbarcode-fontoptions="bold">
</svg></th>
               </tr>
        </table>

  


        @foreach($item as $test)
        <div class="container-fluid content-block">
        <h2 align="center" style="font-weight:bold;color:red">{{$test->test->name ??""}}</h2>
        <hr>
        </div>

        <table class="table table-bordered table-striped content-block" style="text-align:left">
        <thead>
            <tr>
                <th>TEST</th>
                <th>RESULT</th>
                <th>UNIT</th>
                <th>Normal Range</th>
            </tr>
        </thead>
       
        <tbody>
            @foreach(App\Models\PatTestComponet::where("pat_test_id",$test->id)->get() as $sub)
        <tr>
                <th>{{$sub->componet->name ??""}}</th>
                <th @if(stripos($sub->result ?? '', 'Positive') !== false) style="color: green;" @endif>{{$sub->result ??""}}</th>

                <th>{{$sub->componet->unit ??""}}</th>

                <th style="white-space: pre;">{{$sub->componet->normal_range ??""}}</th>

            </tr>
            @endforeach
        </tbody>

        <tfoot>
    <tr>
      <td id="spacer" colspan="4"></td>
    </tr>
  </tfoot>
        </table>

        @endforeach
    


     




      </div>
     
    </div>
  </div>


  


  <img id="footer" src="{{asset('d.png')}}" width="100%">

  </div>
  <div style="page-break-before: always"></div>
  @endforeach

  @if($lab->image)
  <img src="{{asset('storage/'.$lab->image)}}" width="100%">
  @endif
</body>

<script src="{{asset('js/barcode.js')}}"></script>
 <script>
     JsBarcode(".barcode").init();

     function copyShareUrl() {
         const urlInput = document.getElementById('shareUrlInput');
         urlInput.select();
         navigator.clipboard.writeText(urlInput.value).then(function() {
             // Show success feedback
             const copyBtn = event.target;
             const originalText = copyBtn.innerHTML;
             copyBtn.innerHTML = '<i class="fa fa-check"></i> تم النسخ!';
             copyBtn.classList.remove('btn-secondary');
             copyBtn.classList.add('btn-success');

             setTimeout(() => {
                 copyBtn.innerHTML = originalText;
                 copyBtn.classList.remove('btn-success');
                 copyBtn.classList.add('btn-secondary');
             }, 2000);
         }, function(err) {
             alert('فشل في نسخ الرابط');
         });
     }

     function shareLabTest() {
         const shareBtn = document.getElementById('shareBtn');
         const originalText = shareBtn.innerHTML;
         shareBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> جاري المشاركة...';
         shareBtn.disabled = true;

        // Collect all the data
        const labData = @json($lab->toArray());
        const patientData = @json($lab->patient->toArray());
        const testsData = @json($tests->toArray());
        const componentsData = @json($componentsData);

         const data = {
             lab_data: labData,
             patient_data: patientData,
             tests_data: testsData,
             components_data: componentsData
         };

         fetch('/share-lab', {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
             body: JSON.stringify(data)
         })
         .then(response => response.json())
         .then(data => {
          console.log(data);

             if (data.success) {
                 // Show share URL
                 document.getElementById('shareUrlInput').value = data.share_url;
                 document.getElementById('shareUrlContainer').style.display = 'block';

                 // Scroll to share URL
                 document.getElementById('shareUrlContainer').scrollIntoView({ behavior: 'smooth' });
             } else {
                 console.log(data);
                 alert('حدث خطأ أثناء مشاركة التقرير');
             }
         })
         .catch(error => {
             console.error('Error:', error);
             console.log(error);
           //  alert('حدث خطأ أثناء مشاركة التقرير');
         })
         .finally(() => {
             shareBtn.innerHTML = originalText;
             shareBtn.disabled = false;
         });
     }
 </script>

</html>