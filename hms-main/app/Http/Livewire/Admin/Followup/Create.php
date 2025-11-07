<?php

namespace App\Http\Livewire\Admin\Followup;

use App\Models\FollowUp;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Patient;

class Create extends Component
{
    use WithFileUploads;

    public $bp;
    public $pr;
    public $drain;
    public $itake;
    public $spo2;
    public $Temp;
    public $treatment;
    public $pat_id;
    public $date;
    public $output;
    public $bowol_sounds;
    protected $queryString = ['pat_id'];

    protected $rules = [
        'pat_id' => 'required',        'date' => 'required',        
    ];

    public function mount()
    {
        $this->date = date("Y-m-d");
    }

    public function sendMessage($number,$body){
        

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://45.77.74.237:8080/chat/send/text');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            'Content-Type: application/json', // Adjust the content type as needed
          // Add any other headers you need
          'Token:hms112233'
        ];
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = [
            'Phone' => $number,
            'Body' => $body,
            'Id'=>"90B2F8B13FAC8A9CF6B06E99C7834DC5"
        ];
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);


        return redirect(route(getRouteName().'.followup.read') . "?patient_id=".$this->pat_id);
      

    //     $curl = curl_init();

        

    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => "https://api.ultramsg.com/instance18364/messages/chat",
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => "",
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 30,
    //       CURLOPT_SSL_VERIFYHOST => 0,
    //       CURLOPT_SSL_VERIFYPEER => 0,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => "POST",
    //       CURLOPT_POSTFIELDS => "token=k56owergv4hbbq8i&to=$number&body=$body&priority=1&referenceId=",
    //       CURLOPT_HTTPHEADER => array(
    //         "content-type: application/x-www-form-urlencoded"
    //       ),
    //     ));
        
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
        
    //     curl_close($curl);
        
    //     if ($err) {
    //     //  echo "cURL Error #:" . $err;
    //     } else {
    //   //    echo $response;
    //     }

    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {

        $com = (string)$this->bowol_sounds;
       

        $pat = Patient::find($this->pat_id);
        $opname = $pat->operation->name ??"";
        $user = auth()->user()->name;

        $body = "تم اضافة ملاحظة جديدة
المريض : *$pat->name*
****************************
العملية : *$opname*
****************************
التاريخ : $this->date
****************************
";

if($this->bp){
    $body = $body . "
BP:*$this->bp*
    ";
}

if($this->pr){
    $body = $body . "
Pr:*$this->pr*
    ";
}

if($this->drain){
    $body = $body . "
drain:*$this->drain*
    ";
}

if($this->itake){
    $body = $body . "
itake:*$this->itake*
    ";
}



if($this->Temp){
    $body = $body . "
Temp:*$this->Temp*
    ";
}

if($this->spo2){
    $body = $body . "
spo2:*$this->spo2*
    ";
}

if($this->output){
    $body = $body . "
output:*$this->output*
    ";
}


$body = $body . "
****************************";

if($com){
    $body = $body . "
Bowol Sounds : " . $com ;
}
$body = $body . "
****************************
treatment:
*$this->treatment*
****************************
الممرضة : *$user*
";











   

       
     
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('FollowUp') ])]);
        
        FollowUp::create([
            'bp' => $this->bp,
            'pr' => $this->pr,
            'drain' => $this->drain,
            'itake' => $this->itake,
            'spo2' => $this->spo2,
            'Temp' => $this->Temp,
            'treatment' => $this->treatment,
            'pat_id' => $this->pat_id,
            'date' => $this->date,
            'output'=>$this->output,
            'user_id' => auth()->id(),
        ]);

        $this->sendMessage($pat->doctor->phone ??"",($body));

        $this->sendMessage("+9647518775861",($body));

       
     
    }

    public function render()
    {
        return view('livewire.admin.followup.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('FollowUp') ])]);
    }
}
