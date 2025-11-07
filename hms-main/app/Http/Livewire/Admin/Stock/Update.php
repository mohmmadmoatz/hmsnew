<?php

namespace App\Http\Livewire\Admin\Stock;

use App\Models\Stock;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $stock;

    public $name;
    public $price;
    public $qty;
    public $notes;
    public $image;
    
    protected $rules = [
        'name' => 'required',        'price' => 'required',        'qty' => 'required',        
    ];

    public function mount(Stock $stock){
        $this->stock = $stock;
        $this->name = $this->stock->name;
        $this->price = $this->stock->price;
        $this->qty = $this->stock->qty;
        $this->notes = $this->stock->notes;
        $this->image = $this->stock->image;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Stock') ]) ]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles');
        }

        $this->stock->update([
            'name' => $this->name,
            'price' => $this->price,
            'qty' => $this->qty,
            'notes' => $this->notes,
            'image' => $this->image,            
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stock.update', [
            'stock' => $this->stock
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Stock') ])]);
    }
}
