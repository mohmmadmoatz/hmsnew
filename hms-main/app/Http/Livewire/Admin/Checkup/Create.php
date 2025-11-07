<?php

namespace App\Http\Livewire\Admin\Checkup;

use App\Models\Checkup;
use App\Models\Setting;
use App\Models\Patient;
use App\Models\Payments;


use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $note;
    public $image;
    public $patient_id;
    public $payment_id;
    protected $queryString = ['patient_id','payment_id'];
    protected $rules = [
        'image' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Checkup') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/clc','public');
        }
        $settings = Stage::find(1);
      $checkup =   Checkup::create([
            "patient_id"=>$this->patient_id,
            "doctor_id"=>$settings->doctor_id,
            'notes' => $this->note,
            'image' => $this->image,            
        ]);


        $pat = Payments::find($this->payment_id);
        $pat->redirect_done = $checkup->id;
        $pat->save();

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.checkup.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Checkup') ])]);
    }
}
