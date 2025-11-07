<?php

namespace App\Http\Livewire\Admin\Sonar;

use App\Models\Sonar;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
use Livewire\WithFileUploads;

class Read extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $note;
    public $image;
    public $search;
    public $status;
    public $userId;
    public $patientname;

    protected $queryString = ['search'];

    protected $listeners = ['checkupDeleted'];
    
    public $sortType;
    public $patients;
    public $sortColumn;

    public function sonarDeleted(){
        // Nothing ..
    }

    public function dothecheackup($data)
    {
      
    $this->userId = $data["id"];
    $this->patientname = $data["name"];
    
    
    }


    public function create()
    {

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Checkup') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('images/articles','public');
        }

        Sonar::create([
            'notes' => $this->note,
            'image' => $this->image,  
            'patient_id' => $this->userId,  
                      
        ]);

        if ($this->status) {
            $dataa =  Patient::find($this->userId);
            $dataa->status  = $this->status;
            $dataa->save();
        }
  




        $this->reset();
    }


    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function render()
    {
        $data = Sonar::query();

        if(config('easy_panel.crud.sonar.search')){
            $array = (array) config('easy_panel.crud.sonar.search');
            $data->where(function (Builder $query) use ($array){
                foreach ($array as $item) {
                    if(!is_array($item)) {
                        $query->orWhere($item, 'like', '%' . $this->search . '%');
                    } else {
                        $query->orWhereHas(array_key_first($item), function (Builder $query) use ($item) {
                            $query->where($item[array_key_first($item)], 'like', '%' . $this->search . '%');
                        });
                    }
                }
            });
        }

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $this->patients = Patient::where("status","4")->get();

        

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }
        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.sonar.read', [
            'sonars' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Sonar')) ]);
    }
}
