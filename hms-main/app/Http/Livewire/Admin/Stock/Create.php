<?php

namespace App\Http\Livewire\Admin\Stock;

use App\Models\Stock;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $price;
    public $qty;
    public $notes;
    public $image;
    
    protected $rules = [
        'name' => 'required',        'price' => 'required',        'qty' => 'required',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Stock') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        Stock::create([
            'name' => $this->name,
            'price' => $this->price,
            'qty' => $this->qty,
            'notes' => $this->notes,
            'image' => $this->image,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.stock.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Stock') ])]);
    }
}
