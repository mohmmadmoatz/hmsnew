<?php

namespace App\Http\Livewire\Admin\Stage;

use App\Models\Stage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $doctor_id;
    public $total_price;
    public $doctor_price;
    public $other_price;
    public $res_price;
    protected $rules = [
        'name' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Stage') ])]);
        
        Stage::create([
            'name' => $this->name,
            'doctor_id' => $this->doctor_id,            'total_price' => $this->total_price,            
            'doctor_price' => $this->doctor_price,            
            'other_price' => $this->other_price,            
            'res_price' => $this->res_price,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.stage.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Stage') ])]);
    }
}
