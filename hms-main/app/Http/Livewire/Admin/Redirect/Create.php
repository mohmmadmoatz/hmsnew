<?php

namespace App\Http\Livewire\Admin\Redirect;

use App\Models\Redirect;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $pat_id;
    public $redirect_id;
    public $redirect_doctor_id;
    
    protected $rules = [
        'pat_id' => 'required',        'redirect_id' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Redirect') ])]);
        
        Redirect::create([
            'pat_id' => $this->pat_id,            'redirect_id' => $this->redirect_id,            'redirect_doctor_id' => $this->redirect_doctor_id,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.redirect.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Redirect') ])]);
    }
}
