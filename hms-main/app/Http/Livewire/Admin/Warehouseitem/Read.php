<?php

namespace App\Http\Livewire\Admin\Warehouseitem;

use App\Models\Warehouseproduct;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['warehouseitemDeleted'];

    public $sortType;
    public $sortColumn;

    public $expire;

    public $cat;

    public function warehouseitemDeleted(){
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
        $data = Warehouseproduct::query();

        if(config('easy_panel.crud.warehouseitem.search')){
            $array = (array) config('easy_panel.crud.warehouseitem.search');
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


        if($this->expire == 1){
            $data->whereDate('expire', '<', now());
        }elseif($this->expire == 2){
            $data->whereDate('expire', '>', now());
            $data->whereDate('expire', '<', now()->addDays(30));
        }
        
        if($this->cat){
            $data->where('cat_id', $this->cat);
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));



        return view('livewire.admin.warehouseitem.read', [
            'warehouseitems' => $data
        ])->layout('admin::layouts.app', ['title' => "مواد المخزن" ]);
    }
}
