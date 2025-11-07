<?php

namespace App\Http\Livewire\Admin\Fdebittransaction;

use App\Models\FdebitTransaction;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','daterange'];

    protected $listeners = ['fdebittransactionDeleted'];

    public $sortType;
    public $sortColumn;

    public $category_id;

    public $total_amount_iqd;
    public $total_amount_usd;

    public $datefilterON;
    public $daterange;


    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function fdebittransactionDeleted(){
        // Nothing ..
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function getDataProperty()
    {
        $data = FdebitTransaction::query();

        if(config('easy_panel.crud.fdebittransaction.search')){
            $array = (array) config('easy_panel.crud.fdebittransaction.search');
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

         if($this->datefilterON){
            $dates = explode(' - ', $this->daterange);
            $data->whereBetween('date', [$dates[0], $dates[1]]);
          
        }


        return $data;
    }


    

    public function render()
    {
        $data = $this->data;

        if($this->category_id){
            $data->where('category_id', $this->category_id);
        }

        $this->total_amount_iqd = $data->sum('amount_iqd');
        $this->total_amount_usd = $data->sum('amount_usd');

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.fdebittransaction.read', [
            'fdebittransactions' => $data
        ])->layout('admin::layouts.app', ['title' => "وصولات الديون الثابتة" ]);
    }
}
