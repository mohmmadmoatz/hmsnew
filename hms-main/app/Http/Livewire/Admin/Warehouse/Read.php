<?php

namespace App\Http\Livewire\Admin\Warehouse;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','product'];

    protected $listeners = ['warehouseDeleted'];

    public $sortType;
    public $sortColumn;
    public $product;

    public function warehouseDeleted(){
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
        $data = Warehouse::query();

        if(config('easy_panel.crud.warehouse.search')){
            $array = (array) config('easy_panel.crud.warehouse.search');
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

        if($this->product){
            $pr = $this->product;
            $data->whereHas('items', function($q) use($pr){
                $q->where('product_id', $pr);
            });
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.warehouse.read', [
            'warehouses' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Warehouse')) ]);
    }
}
