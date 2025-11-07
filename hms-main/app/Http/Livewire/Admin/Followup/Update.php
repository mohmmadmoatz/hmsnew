<?php

namespace App\Http\Livewire\Admin\Followup;

use App\Models\FollowUp;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $followup;

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
    
    protected $rules = [
        'pat_id' => 'required',        'date' => 'required',        
    ];

    public function mount(FollowUp $followup){
        $this->followup = $followup;
        $this->bp = $this->followup->bp;
        $this->pr = $this->followup->pr;
        $this->drain = $this->followup->drain;
        $this->itake = $this->followup->itake;
        $this->spo2 = $this->followup->spo2;
        $this->Temp = $this->followup->Temp;
        $this->treatment = $this->followup->treatment;
        $this->pat_id = $this->followup->pat_id;
        $this->date = $this->followup->date;        
        $this->output = $this->followup->output;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('FollowUp') ]) ]);
        
        $this->followup->update([
            'bp' => $this->bp,
            'pr' => $this->pr,
            'drain' => $this->drain,
            'itake' => $this->itake,
            'spo2' => $this->spo2,
            'Temp' => $this->Temp,
            'treatment' => $this->treatment,
            'pat_id' => $this->pat_id,
            'date' => $this->date,
            'output' => $this->output,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.followup.update', [
            'followup' => $this->followup
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('FollowUp') ])]);
    }
}
