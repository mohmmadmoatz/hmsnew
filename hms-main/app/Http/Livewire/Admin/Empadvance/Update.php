<?php

namespace App\Http\Livewire\Admin\Empadvance;

use App\Models\Empadvance;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $empadvance;

    public $emp_id;
    public $amount;
    public $details;
    public $date;
    
    protected $rules = [
        'emp_id' => 'required',        'amount' => 'required',        
    ];

    public function mount(Empadvance $empadvance){
        $this->empadvance = $empadvance;
        $this->emp_id = $this->empadvance->emp_id;
        $this->amount = $this->empadvance->amount;
        $this->details = $this->empadvance->details;
        $this->date = $this->empadvance->date;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Empadvance') ]) ]);
        
        $this->empadvance->update([
            'emp_id' => $this->emp_id,            'amount' => $this->amount,            'details' => $this->details,            'date' => $this->date,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.empadvance.update', [
            'empadvance' => $this->empadvance
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Empadvance') ])]);
    }
}
