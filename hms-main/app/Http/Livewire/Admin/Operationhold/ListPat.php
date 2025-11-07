<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\OperationHold;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Room;
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

    protected $queryString = ['search'];

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


        
       

        

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.operationhold.list', [
            'operationholds' => $data,
          
        ])->layout('admin::layouts.app', ['title' => "عمليات" ]);
    }
}
