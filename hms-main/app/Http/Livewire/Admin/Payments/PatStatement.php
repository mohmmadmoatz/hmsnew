<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
class PatStatement extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $datefilterON;
    public $daterange;
    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function getGroupedProperty()
    {
        $data = Payments::query();
        $data->select("patinet_id",
        DB::raw("SUM(IF(payment_type=1, amount_iqd, 0)) AS totalexpenseiqd"), 
        DB::raw("SUM(IF(payment_type=2, amount_iqd, 0)) AS totalincomeiqd"), 
        DB::raw("SUM(IF(payment_type=1, amount_usd, 0)) AS totalexpenseusd"), 
        DB::raw("SUM(IF(payment_type=2, amount_usd, 0)) AS totalincomeusd") 
       );

        $data->where("patinet_id","!=",0);

        if($this->search){
            $array = [['Patient'=>"name"],['Patient'=>"id"]];
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

        if($this->datefilterON){
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
        }


        $data->with("Patient:id,name");
        $data->groupBy("patinet_id");
        $data->latest();

        $data = $data->paginate(config('easy_panel.pagination_count', 15));
        
        return $data;
        
    }

    public function render()
    {
       

        return view('livewire.admin.payments.acountstatement', [
            'Grouped'=>$this->grouped
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Payments')) ]);
    }

}