<?php

namespace App\Http\Livewire\Admin;

use App\Models\Stocksup;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Stockreport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['stocksupDeleted'];

    public $sortType;
    public $sortColumn;
    public $name;
    public $company;
    public $daterange;
    public $datefilterON;

    public function stocksupDeleted(){
        // Nothing ..
    }

    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function render()
    {
        $data = Stocksup::query();

        if(config('easy_panel.crud.stocksup.search')){
            $array = (array) config('easy_panel.crud.stocksup.search');
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

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.stockreport', [
            'stocksups' => $data
        ])->layout('admin::layouts.app', ['title' => "كشف قسم" ]);
    }
}
