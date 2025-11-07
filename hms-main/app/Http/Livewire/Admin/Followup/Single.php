<?php

namespace App\Http\Livewire\Admin\Followup;

use App\Models\FollowUp;
use Livewire\Component;

class Single extends Component
{

    public $followup;

    public function mount(FollowUp $followup){
        $this->followup = $followup;
    }

    public function delete()
    {
        $this->followup->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('FollowUp') ]) ]);
        $this->emit('followupDeleted');
    }

    public function render()
    {
        return view('livewire.admin.followup.single')
            ->layout('admin::layouts.app');
    }
}
