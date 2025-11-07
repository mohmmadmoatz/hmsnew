<?php

namespace App\Http\Livewire\Admin\Stage;

use App\Models\Stage;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['stageDeleted'];

    public $sortType;
    public $sortColumn;

    public function stageDeleted(){
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
        $data = Stage::query();

        if(config('easy_panel.crud.stage.search')){
            $array = (array) config('easy_panel.crud.stage.search');
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

        $data= $data->where("id","!=",5);

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.stage.read', [
            'stages' => $data
        ])->layout('admin::layouts.app', ['title' => "التوجيهات" ]);
    }
}
