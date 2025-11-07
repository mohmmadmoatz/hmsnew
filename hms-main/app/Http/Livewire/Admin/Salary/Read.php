<?php

namespace App\Http\Livewire\Admin\Salary;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bank;
class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $month;

    protected $queryString = ['month'];

    protected $listeners = ['salaryDeleted'];

    public $sortType;
    public $sortColumn;

    public $selected = [];
    public $selectall;
    public $wasl_number;
    public function salaryDeleted(){
        // Nothing ..
    }

    public function mount()
    {
        $this->month = Date("Y-m");
    }

    public function updatedSelectall($value)
    {
        $this->selected = $value ? $this->data->pluck('id')->toArray() : [];
        
        $this->selected = array_map('strval', $this->selected);
      
    }

    public function returnSalary($empid)
    {
        $year = explode('-', $this->month)[0];
        $month = explode('-', $this->month)[1];


        $salary = Salary::where('emp_id', $empid)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->delete();
        
    }

    public function paySalary($id,$netamount)
    {
        $new = new Salary();
        $new->emp_id = $id;
        $new->date = $this->month . '-01';
        $new->total = $netamount;
        $new->save();
    }

    public function payAllSalary()
    {
        $total =0;

            // pay all based on selected
            foreach ($this->selected as $id) {

                $emp = $this->data->where('id', $id)->first();
                $netamount = $emp->salary -  $emp->empadvance->sum("amount");
                $total += $netamount;
                $this->paySalary($id,$netamount);

            }
          
            Bank::create([
                'wasl_number' => $this->wasl_number,
                'description' => "دفع رواتب الشهر ".$this->month,
                'amount_iqd' => $total,
                'date' => Date("Y-m-d"),
                'user_id' => auth()->id(),
            ]);

            $this->wasl_number = "";

            $this->selected = [];
            $this->selectall = false;
            $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم دفع الرواتب" ]);
            $this->emit('salaryDeleted');

    }

    public function getDataProperty()
    {
        $data = Employee::query();

        if(config('easy_panel.crud.salary.search')){
            $array = (array) config('easy_panel.crud.salary.search');
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
        
        $year = explode('-', $this->month)[0];
        $month = explode('-', $this->month)[1];

     
        $data->with('empadvance', function ($query) use($month, $year) {
            $query->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->selectRaw('id,emp_id, amount');
        });
        
       
        $data->with('salaries', function ($query) use($month, $year) {
            $query->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->selectRaw('id,emp_id');
        });

        $data = $data->paginate(config('easy_panel.pagination_count', 100));
        return $data;

    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function render()
    {
       

    
        
      
       


        

        return view('livewire.admin.salary.read', [
            'employee' => $this->data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Salary')) ]);
    }
}
