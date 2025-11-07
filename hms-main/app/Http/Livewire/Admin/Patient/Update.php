<?php

namespace App\Http\Livewire\Admin\Patient;

use App\Models\Patient;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $patient;

    public $name;
    public $gender;
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
    public $Nationality;
    public $adress;

    public $husbandname;
    public $idSingle;
    public $iddate;
    public $idcreatejeha;
    public $identity_number;
    public $hms_nsba;

    public $redirect_doctor_id;


    protected $rules = [
        'name' => 'required',        
    ];

    public function mount(Patient $patient){
        $this->patient = $patient;
        $this->name = $this->patient->name;
        $this->age = $this->patient->age;
        $this->gender = $this->patient->gender;
        $this->phone = $this->patient->phone;
        $this->status = $this->patient->status;
        $this->image = $this->patient->image;        
        $this->clinic_id = $this->patient->clinic_id;
        if($this->status==5){
            $roomdata = Room::find($this->patient->room_id);
            $this->floor = $roomdata->floor ??"";
        }
 

        $this->room_id = $this->patient->room_id;
        $this->doctor_id = $this->patient->doctor_id;
        $this->opration_id = $this->patient->opration_id;
        $this->inter_at = $this->patient->inter_at;
        $this->identity_circule = $this->patient->identity_circule;
        $this->identity_page = $this->patient->identity_page;
        $this->identity_book = $this->patient->identity_book;
        $this->relaitve_name = $this->patient->relaitve_name;
        $this->relaitve_phone = $this->patient->relaitve_phone;
        $this->job = $this->patient->job;
        $this->mother = $this->patient->mother;
        $this->Nationality = $this->patient->Nationality;
        $this->adress = $this->patient->adress;

        $this->husbandname = $this->patient->husbandname;
        $this->idSingle = $this->patient->idSingle;
        $this->iddate = $this->patient->iddate;
        $this->idcreatejeha = $this->patient->idcreatejeha;
        $this->identity_number = $this->patient->identity_number;
        $this->hms_nsba = $this->patient->hms_nsba;
        $this->redirect_doctor_id = $this->patient->redirect_doctor_id;
    


    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {

        
        $room = Room::find($this->room_id);
        if($room){
            if($room->patient_id){
                $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' =>  "لايمكن ادخال المريض الى هذه الغرفة  !!!"]);
                return;
                }
        }
        
       

        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Patient') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/patients','public');
        }

        $updatedata =[
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
            'adress'=>            $this->adress,
            'husbandname'=>$this->husbandname,           
                'idSingle'=>$this->idSingle,           
                'iddate'=>$this->iddate,           
                'idcreatejeha'=>$this->idcreatejeha ,
                'identity_number'=>$this->identity_number,
                'hms_nsba'=>$this->hms_nsba,
                "redirect_doctor_id"=>$this->redirect_doctor_id

                          
        ];

        $oldroom = $this->patient->room_id;

        $oldroomupdate = Room::find($oldroom);
        if($oldroomupdate){
            $oldroomupdate->patient_id =0;
            $oldroomupdate->save();
        }
      
        if($this->patient->status !=5){
            $updatedata['paid']=0;
        }


        $room = Room::find($this->room_id);
        if($room){
            $room->patient_id=$this->patient->id;
            $room->save();
        }
      
        $this->patient->update($updatedata);

        // find operation and update patient_id
        $operation = \App\Models\OperationHold::where('patinet_id',$this->patient->id)->first();
        if($operation){
            $operation->doctor_id = $this->doctor_id;
            $operation->save();
        }
    }

    public function render()
    {
        return view('livewire.admin.patient.update', [
            'patient' => $this->patient
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Patient') ])]);
    }
}
