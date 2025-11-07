<?php

namespace App\Http\Livewire\Admin\Bank;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','datefilterON','daterange'];

    protected $listeners = ['bankDeleted'];

    public $sortType;
    public $sortColumn;

    public $total;
    public $total_usd;

    // date filter
    public $datefilterON;
    public $daterange;


    
    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function bankDeleted(){
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
        $data = Bank::query();

        if(config('easy_panel.crud.bank.search')){
            $array = (array) config('easy_panel.crud.bank.search');
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
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $this->total= Bank::whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59'])->sum("amount_iqd");
            $this->total_usd= Bank::whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59'])->sum("amount_usd");
        }else{
            $this->total = Bank::sum("amount_iqd");
            $this->total_usd = Bank::sum("amount_usd");
        }


      

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.bank.read', [
            'banks' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Bank')) ]);
    }
}
