<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\OperationHold;
use App\Models\Payments;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $datefilterON;
    public $daterange;
    public $doctor_id;

    public $total_doctor;


    protected $queryString = ['search'];

    protected $listeners = ['operationholdDeleted','row:update' => '$refresh'];

    public $sortType;
    public $sortColumn;

    public function saveallinone()
    {
        $data = OperationHold::query();
        $date1 = explode(" - ", $this->daterange)[0];
        $date2 = explode(" - ", $this->daterange)[1];
        $data = $data->whereBetween('created_at',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
        $data = $data->where("doctor_id",$this->doctor_id);
      
        $data->update([
            "doctor_paid"=>1
        ]);
        

        $data =[
            'payment_type' => 1,
            'amount_iqd' => $this->total_doctor,
            'account_type' => 1,
            'description' => "اجور عمليات الفترة :  " . $this->daterange,
            'user_id' => auth()->id(),
            "doctor_id"=>$this->doctor_id,

        ];

        Payments::create($data);

        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => "تم انشاء سند صرف" ]);

    }

    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function operationholdDeleted(){
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function render()
    {
        $data = OperationHold::query();
        $sum = OperationHold::query();

        if(config('easy_panel.crud.operationhold.search')){
            $array = (array) config('easy_panel.crud.operationhold.search');
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
        $doctors =  OperationHold::query();
        if($this->datefilterON){
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $sum=$sum->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $doctors = $doctors->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
            $doctors = $doctors->groupBy("doctor_id")->get();
        
        }

        if($this->doctor_id){
            $data->where("doctor_id",$this->doctor_id);
            $sum=$sum->where("doctor_id",$this->doctor_id)
            ->where(function ($query){
                $query->where("doctor_paid",0)
                      ->orWhereNull('doctor_paid');
            })
            
            ->sum("doctorexp");

         
            $this->total_doctor = $sum;
        }

        

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $data = $data
        ->with("Patient")
        ->with("doctor")
        ->with("mqema")
        
        ->paginate(20);

        $settings = Setting::find(1);
        $doctors_res = User::where("user_type","doctor")->orWhere("user_type","resident")->get();

        $this->dispatchBrowserEvent('refreshselect');


        return view('livewire.admin.operationhold.read', [
            'operationholds' => $data,
            'doctors' => $doctors,
            'settings'=>$settings,
            'doctors_res'=>$doctors_res,
          
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('OperationHold')) ]);
    }
}
