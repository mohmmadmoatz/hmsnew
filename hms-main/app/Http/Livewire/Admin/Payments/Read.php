<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','patient_id','groupdata','account_type',"idnumber","daterange"];

    protected $listeners = ['paymentsDeleted'];

    public $sortType;
    public $sortColumn;
    public $datefilterON;
    public $daterange;
    public $total_income_iqd=0;
    public $total_expense_iqd=0;
    public $total_income_usd=0;
    public $total_expense_usd=0;

    public $patient_id;
    public $doctor_id;
    public $account_name;

    public $paytype;
    public $groupdata =true;
    public $account_type;

    public $idnumber;

    public $total_return_iqd;
    public $total_return_usd;

    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

  

    public function paymentsDeleted(){
        // Nothing ..
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

  

    public function getPaymentsProperty()
    {
        # code...
        $data = Payments::query();

       

        if(config('easy_panel.crud.payments.search')){
            $array = (array) config('easy_panel.crud.payments.search');

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


        $summations = Payments::query();
        $summations2 = Payments::query();

     if($this->account_type==2){
        if($this->patient_id){
            $summations = $summations->where("patinet_id",$this->patient_id);
            $summations2 = $summations2->where("patinet_id",$this->patient_id);
            $data = $data->where("patinet_id",$this->patient_id);
        }
    }else if($this->account_type ==1){
        if($this->doctor_id){
            $summations = $summations->where("doctor_id",$this->doctor_id);
            $summations2 = $summations2->where("doctor_id",$this->doctor_id);
            $data = $data->where("doctor_id",$this->doctor_id);
        }
    }else if($this->account_type ==3){
        if($this->account_name){
            $summations = $summations->where("account_name",$this->account_name);
            $summations2 = $summations2->where("account_name",$this->account_name);
            $data = $data->where("account_name",$this->account_name);
        }
    }

        if($this->paytype){
            $summations = $summations->where("payment_type",$this->paytype);
            $summations2 = $summations2->where("payment_type",$this->paytype);
            $data = $data->where("payment_type",$this->paytype);
        }

      

        if($this->datefilterON){
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $summations = $summations->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $summations2 = $summations2->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);

        }else{
            $data = $data->where("id",0);
        }



        if($this->idnumber){
            $data = $data->where("wasl_number",$this->idnumber);
        }
      

        $this->total_income_iqd = $summations->where("payment_type",2)->select(DB::raw('SUM(amount_iqd - return_iqd) as amount_iqd'))->first()->amount_iqd;
        $this->total_income_usd = $summations->where("payment_type",2)->select(DB::raw('SUM(amount_usd - return_usd) as amount_usd'))->first()->amount_usd;


        $this->total_expense_iqd = $summations2->where("payment_type",1)->sum("amount_iqd");
        $this->total_expense_usd = $summations2->where("payment_type",1)->sum("amount_usd");
        

        


        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        


        $data = $data->paginate(config('easy_panel.pagination_count', 15));
        return $data;
    }

    public function render()
    {
       
  

        return view('livewire.admin.payments.read', [
            'paymentss' => $this->payments,
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Payments')) ]);
    }
}
