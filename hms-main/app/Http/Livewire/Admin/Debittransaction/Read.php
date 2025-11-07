<?php

namespace App\Http\Livewire\Admin\Debittransaction;

use App\Models\DebitTransaction;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['debittransactionDeleted'];

    public $sortType;
    public $sortColumn;

    public $account_id;
    public $total_debit_iqd;
    public $total_debit_usd;
    public $total_credit_iqd;
    public $total_credit_usd;
    public $remaining_balance_iqd;
    public $remaining_balance_usd;
    
    public $datefilterON;
    public $daterange;


    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function debittransactionDeleted(){
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
        $data = DebitTransaction::query();

        if(config('easy_panel.crud.debittransaction.search')){
            $array = (array) config('easy_panel.crud.debittransaction.search');
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

        if($this->account_id){
            $data->where('account_id', $this->account_id);
        }

        if($this->datefilterON){
            $dates = explode(' - ', $this->daterange);
            $data->whereBetween('date', [$dates[0], $dates[1]]);
          
        }
        

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }
        return $data;
    }

    public function getDataProperty()
    {
        $data = $this->getData();


        
        // total payment in type 1
        
        $this->total_debit_iqd = $this->getData()->where('payment_type', 2)->sum('amount_iqd');
        $this->total_debit_usd = $this->getData()->where('payment_type', 2)->sum('amount_usd');
        
        // total payment in type 2
        
        $this->total_credit_iqd = $this->getData()->where('payment_type', 1)->sum('amount_iqd');
        $this->total_credit_usd = $this->getData()->where('payment_type', 1)->sum('amount_usd');
        
        // remaining balance
        
        $this->remaining_balance_iqd = $this->total_debit_iqd - $this->total_credit_iqd;
        $this->remaining_balance_usd = $this->total_debit_usd - $this->total_credit_usd;

        $data = $data->paginate(config('easy_panel.pagination_count', 15));



        return $data;
    }

    public function render()
    {
     
       
        



        return view('livewire.admin.debittransaction.read', [
            'debittransactions' => $this->data,

            

        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('DebitTransaction')) ]);
    }
}
