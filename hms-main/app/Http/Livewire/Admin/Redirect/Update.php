<?php

namespace App\Http\Livewire\Admin\Redirect;

use App\Models\Redirect;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $redirect;

    public $pat_id;
    public $redirect_id;
    public $redirect_doctor_id;
    
    protected $rules = [
        'pat_id' => 'required',        'redirect_id' => 'required',        
    ];

    public function mount(Redirect $redirect){
        $this->redirect = $redirect;
        $this->pat_id = $this->redirect->pat_id;
        $this->redirect_id = $this->redirect->redirect_id;
        $this->redirect_doctor_id = $this->redirect->redirect_doctor_id;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Redirect') ]) ]);
        
        $this->redirect->update([
            'pat_id' => $this->pat_id,            'redirect_id' => $this->redirect_id,            'redirect_doctor_id' => $this->redirect_doctor_id,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.redirect.update', [
            'redirect' => $this->redirect
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Redirect') ])]);
    }
}
