<?php

namespace App\Http\Livewire\Admin\Saveaccount;

use App\Models\Saveaccount;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['saveaccountDeleted'];

    public $sortType;
    public $sortColumn;

    public $total_deposit_iqd=0;
    public $total_deposit_usd=0;
    public $total_withdraw_iqd=0;
    public $total_withdraw_usd=0;
    public $total_balance_iqd=0;
    public $total_balance_usd=0;
    

    public function saveaccountDeleted(){
        // Nothing ..
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function getData()
    {
        $data = Saveaccount::query();

        if(config('easy_panel.crud.saveaccount.search')){
            $array = (array) config('easy_panel.crud.saveaccount.search');
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

        return $data;

    }

    public function render()
    {
        $data = $this->getData();
        $this->total_deposit_iqd =$this->getData()->where("type",1)->sum('amount_iqd');
        $this->total_deposit_usd =$this->getData()->where("type",1)->sum('amount_usd');

        $this->total_withdraw_iqd =$this->getData()->where("type",2)->sum('amount_iqd');
        $this->total_withdraw_usd =$this->getData()->where("type",2)->sum('amount_usd');

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.saveaccount.read', [
            'saveaccounts' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Saveaccount')) ]);
    }
}
