<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use Livewire\Component;

class Single extends Component
{

    public $payments;

    public function mount(Payments $payments){
        $this->payments = $payments;
    }

    public function delete()
    {
        $this->payments->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Payments') ]) ]);
        $this->emit('paymentsDeleted');
    }

    public function render()
    {
        return view('livewire.admin.payments.single')
            ->layout('admin::layouts.app');
    }
}
