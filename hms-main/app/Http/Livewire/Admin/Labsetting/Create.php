<?php

namespace App\Http\Livewire\Admin\Labsetting;

use App\Models\LabSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $amount;
    
    protected $rules = [
        'name' => 'required',        'amount' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('LabSetting') ])]);
        
        LabSetting::create([
            'name' => $this->name,
            'amount' => $this->amount,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.labsetting.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('LabSetting') ])]);
    }
}
