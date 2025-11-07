<?php

namespace App\Http\Livewire\Admin\Redirect;

use App\Models\Redirect;
use Livewire\Component;

class Single extends Component
{

    public $redirect;

    public function mount(Redirect $redirect){
        $this->redirect = $redirect;
    }

    public function delete()
    {
        $this->redirect->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Redirect') ]) ]);
        $this->emit('redirectDeleted');
    }

    public function render()
    {
        return view('livewire.admin.redirect.single')
            ->layout('admin::layouts.app');
    }
}
