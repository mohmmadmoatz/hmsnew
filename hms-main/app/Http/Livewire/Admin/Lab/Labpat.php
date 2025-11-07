<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Patient;
use App\Models\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Labpat extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $status;
    protected $queryString = ['search'];

    protected $listeners = ['patientDeleted'];

    public $sortType;
    public $sortColumn;

    public function patientDeleted(){
        // Nothing ..
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function hide($id)
    {
        $pat = Redirect::find($id);
        $pat->labhide = 1;
        $pat->save();
    }

    public function render()
    {
        $data = Redirect::query();

      

        $data->
        where(function (Builder $query) {
          
            $query->where('redirect_id',2)
            ->orWhere('redirect_id',8);
        
    })
        ->where("paid",0)->whereNull("labhide")
        ->where('is_second',auth()->user()->is_second)
        ;

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }
       
          
        
        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.lab.labpat', [
            'patients' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Patient')) ]);
    }
}
