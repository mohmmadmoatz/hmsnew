<?php

namespace App\Http\Livewire\Admin\Empadvance;

use App\Models\Empadvance;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $emp_id;
    public $amount;
    public $details;
    public $date;
    
    protected $rules = [
        'emp_id' => 'required',        'amount' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Empadvance') ])]);
        
        Empadvance::create([
            'emp_id' => $this->emp_id,            'amount' => $this->amount,            'details' => $this->details,            'date' => $this->date,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.empadvance.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Empadvance') ])]);
    }
}
