<?php

namespace App\Http\Livewire\Admin\Patient;

use App\Models\Patient;
use App\Models\Room;
use App\Models\Setting;
use App\Models\MedicineProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Redirect;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $gender = "انثى";
    public $phone;
    public $patientid;
    public $floor;

    public $status;
    public $image;
    public $clinic_id;
    public $age;
    public $room_id;
    public $doctor_id;
    public $opration_id;
    public $inter_at;
    public $identity_circule;
    public $identity_page;
    public $identity_book;
    public $relaitve_name;
    public $relaitve_phone;
    public $job;
    public $mother;
    public $Nationality = "عراقي";
    public $adress;
    public $husbandname;
    public $idSingle;
    public $iddate;
    public $idcreatejeha;
    public $identity_number;
    public $hms_nsba;
    public $redirect_doctor_id;
    public $patinfo;
    public $selected;
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function mount()
    {
        $this->inter_at = date("Y-m-d");
        $this->hms_nsba= 100 - Setting::find(1)->hnsba;
    }

    public function selectpat($id)
    {
        $this->patinfo = Patient::find($id);
        $this->selected = true;
        $this->name = $this->patinfo->name;
        $this->age = $this->patinfo->age;
        $this->gender = $this->patinfo->gender;
        $this->phone = $this->patinfo->phone;
    }

    public function updatedName()
    {
        $this->selected = false;
    }

    public function clear()
    {
        $this->patinfo = "";
        $this->selected = false;
        $this->name ="";
        $this->age = "";
        $this->gender = "";
        $this->phone = "";
    }

    public function create()
    {

        if($this->status == 1){
            if(!$this->redirect_doctor_id){
                $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "يرجى اختيار الطبيب"]);
                return;
            }
        }

        if($this->status == 4){
            if(!$this->redirect_doctor_id){
                $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "يرجى اختيار الطبيب"]);
                return;
            }
        }

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Patient') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/patients','public');
        }
        
        if($this->patinfo){
            
        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم اعادة توجيه المريض"]);

        Redirect::create([
            "pat_id"=>$this->patinfo->id,
            "redirect_id"=>$this->status,
            "redirect_doctor_id"=>$this->redirect_doctor_id,
        ]);

        $updatepat = Patient::find($this->patinfo->id);
        $updatepat->update([
            'name' => $this->name,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'status' => $this->status,
            'image' => $this->image,            
            'age' => $this->age,            
            'clinic_id' => $this->clinic_id,
            'room_id' =>$this->room_id,
            'doctor_id'=>$this->doctor_id,
            'opration_id'=>$this->opration_id,       
            'inter_at'=>$this->inter_at,
            'identity_circule'=>$this->identity_circule,
            'identity_page'=>$this->identity_page,
            'identity_book'=>$this->identity_book,
            'relaitve_name'=>$this->relaitve_name,
            'relaitve_phone'=>$this->relaitve_phone,
            'job'=>$this->job,
            'mother'=>$this->mother,
            'Nationality'=>$this->Nationality,
            'adress'=>$this->adress,  
            'husbandname'=>$this->husbandname,           
            'idSingle'=>$this->idSingle,           
            'iddate'=>$this->iddate,           
            'idcreatejeha'=>$this->idcreatejeha   ,
            'identity_number'=>$this->identity_number,
            'hms_nsba'=>$this->hms_nsba,
            'redirect_doctor_id'=>$this->redirect_doctor_id,
                       
        ]);

        $this->dispatchBrowserEvent('open-window', ['url' => route('printcard').'?id=' . $this->patinfo->id]);




        }else{
            $this->patientid=Patient::create([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'status' => $this->status,
                'image' => $this->image,            
                'age' => $this->age,            
                'clinic_id' => $this->clinic_id,
                'room_id' =>$this->room_id,
                'doctor_id'=>$this->doctor_id,
                'opration_id'=>$this->opration_id,       
                'inter_at'=>$this->inter_at,
                'identity_circule'=>$this->identity_circule,
                'identity_page'=>$this->identity_page,
                'identity_book'=>$this->identity_book,
                'relaitve_name'=>$this->relaitve_name,
                'relaitve_phone'=>$this->relaitve_phone,
                'job'=>$this->job,
                'mother'=>$this->mother,
                'Nationality'=>$this->Nationality,
                'adress'=>$this->adress,  
                'husbandname'=>$this->husbandname,           
                'idSingle'=>$this->idSingle,           
                'iddate'=>$this->iddate,           
                'idcreatejeha'=>$this->idcreatejeha   ,
                'identity_number'=>$this->identity_number,
                'hms_nsba'=>$this->hms_nsba,
                'redirect_doctor_id'=>$this->redirect_doctor_id,
                           
            ]);

            Redirect::create([
                "pat_id"=>$this->patientid->id,
                "redirect_id"=>$this->status,
                "redirect_doctor_id"=>$this->redirect_doctor_id,
            ]);
    
            if($this->room_id){
            $room = Room::find($this->room_id);
            $room->patient_id=$this->patientid->id;
            $room->checked = null;
            $room->save();
            }
        $this->dispatchBrowserEvent('open-window', ['url' => route('printcard').'?id=' . $this->patientid->id]);

        }

       



        $this->reset();



        $this->hms_nsba=100 - Setting::find(1)->hnsba;
        $this->inter_at = date("Y-m-d");

        // dispatch print 




    }

    public function render()
    {
        return view('livewire.admin.patient.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Patient') ])]);
    }
}
