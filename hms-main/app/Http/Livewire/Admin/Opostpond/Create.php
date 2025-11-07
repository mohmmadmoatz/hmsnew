<?php

namespace App\Http\Livewire\Admin\Opostpond;

use App\Models\Opostpond;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $operationhold_id;
    public $date;
    public $reason;
    
    public $queryString = ['operationhold_id'];

    protected $rules = [
        'date' => 'required',
        'reason' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Opostpond') ])]);
        
        Opostpond::create([
            'operationhold_id' => $this->operationhold_id,
            'date' => $this->date,
            'reason' => $this->reason,
            'status'=>"pending"            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.opostpond.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Opostpond') ])]);
    }
}
