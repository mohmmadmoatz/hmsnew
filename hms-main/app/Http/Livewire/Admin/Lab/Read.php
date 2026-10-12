<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
use App\Models\Redirect;
use App\Models\Payments;
class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search','patient_id'];

    protected $listeners = ['labDeleted'];

    public $sortType;
    public $sortColumn;

    public $patient_id;
    public $searchpat;

    public $patinfo;
    public $selected;

  

    public function selectpat($id)
    {
        $this->patinfo = Patient::find($id);
        $this->selected = true;
        $this->patient_id = $this->patinfo->id;
     
    }

    public function clear()
    {
        $this->patinfo = "";
        $this->selected = false;
        $this->patient_id = "";
       
    }


    public function labDeleted(){
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
        $data = Lab::query();

        if(config('easy_panel.crud.lab.search')){
            $array = (array) config('easy_panel.crud.lab.search');
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

        $pending = collect();

        if($this->patient_id){
            // فحوصات مريض محدد: نعرض كل فحوصاته من المختبرين
            $data = $data->where("patient_id",$this->patient_id);

            // الفحوصات المطلوبة الي بعد ما انطت نتيجة
            $redirects = Redirect::where("pat_id",$this->patient_id)
                ->whereNotNull("lab")
                ->whereNull("labhide")
                ->latest("id")
                ->get();

            foreach ($redirects as $rd) {
                $tests = json_decode($rd->lab, true);
                if(!is_array($tests) || !count($tests)){
                    continue;
                }

                if(!$rd->paid){
                    $status = "بانتظار الدفع";
                }else{
                    $payment = Payments::where("rid",$rd->id)->latest("id")->first();
                    if($payment && $payment->redirect_done){
                        continue; // النتيجة موجودة بالجدول
                    }
                    $status = "بانتظار النتيجة";
                }

                $pending->push([
                    "date" => optional($rd->created_at)->format('Y-m-d H:i'),
                    "tests" => collect($tests)->pluck("name")->filter()->implode(" ، "),
                    "status" => $status,
                ]);
            }
        }else{
            $data = $data->where('is_second',auth()->user()->is_second);
        }

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.lab.read', [
            'labs' => $data,
            'pending' => $pending,
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Lab')) ]);
    }
}
