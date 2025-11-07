<?php

namespace App\Http\Livewire\Admin\Labsetting;

use App\Models\LabSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $labsetting;

    public $name;
    public $amount;
    
    protected $rules = [
        'name' => 'required',        'amount' => 'required',        
    ];

    public function mount(LabSetting $labsetting){
        $this->labsetting = $labsetting;
        $this->name = $this->labsetting->name;
        $this->amount = $this->labsetting->amount;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('LabSetting') ]) ]);
        
        $this->labsetting->update([
            'name' => $this->name,
            'amount' => $this->amount,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.labsetting.update', [
            'labsetting' => $this->labsetting
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('LabSetting') ])]);
    }
}
