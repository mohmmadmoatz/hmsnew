<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $setting;

    public $xray;
    public $xray_doctor_price;
    public $xray_doctor_id;

    public $sonar;
    public $doctor_sonar_price;
    public $doctor_sonar_id;
    public $clinic_price;
    public $doctor_price;
    public $doctor_id;

    public $pat_profile;
    public $helper_doctor;
    public $m5dr_doctor;
    public $m5dr_large_doctor;
    public $m5dr_small_doctor;
    public $helper_m5dr_doctor;
    public $qabla;
    public $mqema;
    public $not_supervised;
    public $supervised;
    public $mqema_id;
    public $nurse_price;
    public $ambulance;
    public $min_op_price;
    public $hnsba;
    public $box_date;
    public $wasl_no;
    public $income_no;
    protected $rules = [
        'xray' => 'required',        
    ];

    public function mount(Setting $setting){
        $this->setting = $setting;
        $this->xray = $this->setting->xray;
        $this->sonar = $this->setting->sonar;
        $this->clinic_price = $this->setting->clinic_price;
        $this->doctor_price = $this->setting->doctor_price;
        $this->doctor_id = $this->setting->doctor_id; 

        $this->pat_profile = $this->setting->pat_profile; 
        $this->helper_doctor = $this->setting->helper_doctor; 
        $this->m5dr_doctor = $this->setting->m5dr_doctor; 

        $this->m5dr_large_doctor = $this->setting->m5dr_large_doctor; 
        $this->m5dr_small_doctor = $this->setting->m5dr_small_doctor; 

        $this->helper_m5dr_doctor = $this->setting->helper_m5dr_doctor; 
        $this->xray_doctor_price = $this->setting->xray_doctor_price;        
        $this->xray_doctor_id = $this->setting->xray_doctor_id;        
        $this->doctor_sonar_price = $this->setting->doctor_sonar_price;        
        $this->doctor_sonar_id = $this->setting->doctor_sonar_id;       
        
        
        $this->qabla = $this->setting->qabla; 
        $this->mqema = $this->setting->mqema;        
        $this->not_supervised = $this->setting->not_supervised;        
        $this->supervised = $this->setting->supervised;        
        $this->mqema_id = $this->setting->mqema_id;        
        $this->nurse_price = $this->setting->nurse_price;        
        $this->ambulance = $this->setting->ambulance;   

        $this->min_op_price = $this->setting->min_op_price;        
        $this->hnsba = $this->setting->hnsba;
        $this->box_date = $this->setting->box_date;   
        $this->wasl_no = $this->setting->wasl_no;     
        $this->income_no = $this->setting->income_no;
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Setting') ]) ]);
        
        $this->setting->update([
            'xray' => $this->xray,            'sonar' => $this->sonar,            'clinic_price' => $this->clinic_price,            'doctor_price' => $this->doctor_price,            'doctor_id' => $this->doctor_id,  
            'xray_doctor_price' => $this->xray_doctor_price,         
            'xray_doctor_id' => $this->xray_doctor_id,         
            'doctor_sonar_price' => $this->doctor_sonar_price,         
            'doctor_sonar_id' => $this->doctor_sonar_id,  

            'pat_profile' => $this->pat_profile,         
            'helper_doctor' => $this->helper_doctor,         
            'm5dr_doctor' => $this->m5dr_doctor,
            'm5dr_large_doctor' => $this->m5dr_large_doctor,         
            'm5dr_small_doctor' => $this->m5dr_small_doctor,         
            'helper_m5dr_doctor' => $this->helper_m5dr_doctor,      
            
            'qabla' => $this->qabla,         
            'mqema' => $this->mqema,
            'not_supervised' => $this->not_supervised,         
            'supervised' => $this->supervised,         
            'mqema_id' => $this->mqema_id,  
            'nurse_price' => $this->nurse_price,  
            'ambulance' => $this->ambulance, 

            'min_op_price' => $this->min_op_price,  
            'hnsba' => $this->hnsba,  
            'box_date' => $this->box_date,  
            'wasl_no' => $this->wasl_no,
            'income_no'=> $this->income_no,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.setting.update', [
            'setting' => $this->setting
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Setting') ])]);
    }
}
