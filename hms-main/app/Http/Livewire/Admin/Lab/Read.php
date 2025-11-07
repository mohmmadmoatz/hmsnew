<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','patient_id'];

    protected $listeners = ['labDeleted'];

    public $sortType;
    public $sortColumn;

    public $patient_id;
    public $searchpat;

    public $patinfo;
    public $selected;

  

    public function selectpat($id)
    {
        $this->patinfo = Patient::find($id);
        $this->selected = true;
        $this->patient_id = $this->patinfo->id;
     
    }

    public function clear()
    {
        $this->patinfo = "";
        $this->selected = false;
        $this->patient_id = "";
       
    }


    public function labDeleted(){
        // Nothing ..
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function render()
    {
        $data = Lab::query();

        if(config('easy_panel.crud.lab.search')){
            $array = (array) config('easy_panel.crud.lab.search');
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

        if($this->patient_id){
            $data = $data->where("patient_id",$this->patient_id);
        }

        $data = $data->where('is_second',auth()->user()->is_second);

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.lab.read', [
            'labs' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Lab')) ]);
    }
}
