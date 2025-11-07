<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    
    public $name;
    public $email;
    public $password;
    public $image;
    public $user_type;
    public $mqema;
    public $phone;
    public $is_second;

    
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

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('User') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles','public');
        }
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password) ,
            'image' => $this->image,            
            'user_type' => $this->user_type,            
            'mqema' => $this->mqema,
            "phone"=>$this->phone,
            "is_second"=>$this->is_second,            
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.user.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('User') ])]);
    }
}
