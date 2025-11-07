<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Payments;
use App\Models\Patient;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
class ConvertedPat extends Component
{

    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';


    protected $queryString = ['search'];
    
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




        $data=  $data->latest()
        
        // where as function
        ->where(function (Builder $query) {
          
                $query->where('redirect',2)
                ->orWhere('redirect',8);
            
        })
        
        ->whereNull("redirect_done")
        // where in relation
        ->whereHas('rid', function (Builder $query) {
            $query->WhereNotNull('lab')
            ->where('is_second',auth()->user()->is_second);
        })
        ->with("Patient:name,id")
        ->with("rid")
        ->paginate(20);

      

        

        return view('livewire.admin.lab.convertedPat', [
            'data' => $data
        ])->layout('admin::layouts.app', ['title' => "محولين الى المختبر" ]);
    }
}