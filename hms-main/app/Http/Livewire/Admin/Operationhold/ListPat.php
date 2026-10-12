<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\OperationHold;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Room;
use App\Models\Redirect;
use App\Models\User;
class ListPat extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $datefilterON;
    public $daterange;
    public $doctor_id;

    public $total_doctor;

    public $room;

    protected $queryString = ['search', 'doctor_id'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDoctorId()
    {
        $this->resetPage();
    }

    protected $listeners = ['operationholdDeleted','row:update' => '$refresh'];

    public $sortType;
    public $sortColumn;



    public function searchBydate($date)
    {
        # code...
        $this->daterange = $date;
        $this->datefilterON = true;
    }

    public function hide($id)
    {
        $data = OperationHold::find($id);
        $data->hide=true;
        $data->save();
        $this->emit('operationholdDeleted');

    }

    public function undo($id)
    {
        $data = OperationHold::find($id);
        $data->hide=false;
        $data->save();
        $this->emit('operationholdDeleted');   
    }
    
    public function notify($id)
    {
        $data = Room::find($id);
        $data->nt_at = date("Y-m-d H:i:s");
        $data->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم اشعار الغرفة بتهيئة المريض الى العمليات  " ]);

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
      
        if($this->datefilterON){
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $data = $data->whereBetween('date',[$date1 .' 00:00:00',$date2 .' 23:59:59']);


        }

        if($this->doctor_id){
            $data->where("doctor_id",$this->doctor_id);
        }

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $data = $data->with("Patient")->with("doctor")->paginate(config('easy_panel.pagination_count', 15));

        // مرضى العمليات الي كملوا الطبلة وبعدهم ما دافعين (نفس قائمة الحسابات)
        $unpaid = Redirect::query()
            ->where("redirect_id",5)
            ->where("paid",0)
            ->whereNull("labhide")
            ->whereHas("Patient", function (Builder $query){
                $query->whereHas("operation");
                if($this->doctor_id){
                    $query->where("doctor_id",$this->doctor_id);
                }
                if($this->search){
                    $query->where(function (Builder $q){
                        $q->where("name","like","%".$this->search."%")
                          ->orWhere("id",$this->search)
                          ->orWhereHas("operation", function (Builder $o){
                              $o->where("name","like","%".$this->search."%");
                          })
                          ->orWhereHas("doctor", function (Builder $d){
                              $d->where("name","like","%".$this->search."%");
                          });
                    });
                }
            });

        if($this->datefilterON){
            $date1 = explode(" - ", $this->daterange)[0];
            $date2 = explode(" - ", $this->daterange)[1];
            $unpaid->whereBetween('created_at',[$date1 .' 00:00:00',$date2 .' 23:59:59']);
        }else{
            // بدون فترة: فقط المرضى الراقدين حالياً او المسجلين خلال اخر 7 ايام
            // (حتى ما تطلع سجلات قديمة ما انغلقت)
            $unpaid->where(function (Builder $query){
                $query->where('created_at','>=',now()->subDays(7))
                      ->orWhereIn('pat_id', Room::where('patient_id','!=',0)->select('patient_id'));
            });
        }

        $unpaid = $unpaid->with("Patient.doctor","Patient.operation","Patient.room")->latest("id")->get();

        $doctors = User::where("user_type","doctor")->orderBy("name")->get();

        // اقتراحات اسماء اطباء التخدير من العمليات السابقة
        $anesthesiaNames = OperationHold::whereNotNull("anesthesia_doctors")
            ->latest("id")->limit(500)->get(["id","anesthesia_doctors"])
            ->pluck("anesthesia_doctors")->flatten()->filter()->unique()->sort()->values();

        return view('livewire.admin.operationhold.list', [
            'operationholds' => $data,
            'unpaid' => $unpaid,
            'doctors' => $doctors,
            'anesthesiaNames' => $anesthesiaNames,

        ])->layout('admin::layouts.app', ['title' => "عمليات" ]);
    }
}
