<?php

namespace App\Http\Livewire\Admin\Sonar;

use App\Models\Payments;
use App\Models\Patient;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
class ConvertedPat extends Component
{
    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['refresh' => '$refresh'];

    function hidePat($id) {
        Payments::where('id',$id)->update(['redirect_done'=>1]);
        $this->emit('refresh');
    }

    function allDone() {
        Payments::where('redirect',4)->where("created_at",">=","2023-04-18")->whereNull("redirect_done")->update(['redirect_done'=>1]);
        $this->emit('refresh');
    }
    
    public function refresh(){
        // Nothing ..
    }

    public function render()
    {
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
        // get data from 01-04-2023 to now

        


        $data=  $data->where('redirect',4)
        ->where("created_at",">=","2023-04-18")
        ->whereNull("redirect_done")->get();
        return view('livewire.admin.sonar.convertedPat', [
            'data' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Payments')) ]);
    }
}