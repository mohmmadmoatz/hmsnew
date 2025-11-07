<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Room;
use App\Models\Patient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class Home extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    protected $queryString = ['search'];

    protected $listeners = ['warehouseDeleted'];

    public $sortType;
    public $sortColumn;

   public $floorid;

    function mount() {
        // check users table if has not column is_second
        if (!Schema::hasColumn('users', 'is_second')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('is_second')->nullable();
            });
        }

        if (!Schema::hasColumn('redirects', 'is_second')) {
            Schema::table('redirects', function (Blueprint $table) {
                $table->string('is_second')->nullable();
            });
        }

        // labs

        if (!Schema::hasColumn('labs', 'is_second')) {
            Schema::table('labs', function (Blueprint $table) {
                $table->string('is_second')->nullable();
            });
        }
        
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';

        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function check($id)
    {
       $room = Room::find($id);
       $room->checked = 1;
       $room->save();

    }

    public function checknt($id)
    {
        $room = Room::find($id);
       $room->nt_at = null;
       $room->save();
    }

    public function outPat($id)
    {
        $room = Room::find($id);
        $patid = $room->patient_id;
        $room->patient_id =0;
        $room->save();
        $pat = Patient::find($patid);
        $pat->room_id = 0;
        $pat->checkout_at = now();
        $pat->checkout_room = $id;
        $pat->checkout_by = auth()->user()->id;
        $pat->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => 'تم اخراج المريض بنجاح' ]);

    }

    public function render()
    {
        $data = Room::query();

        if(config('easy_panel.crud.room.search')){
            $array = (array) config('easy_panel.crud.room.search');
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

        if($this->floorid){
            $data = $data->where("floor",$this->floorid);
        }

        if($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('id');
        }
        

        $data = $data->get();


        return view('vendor.admin.home', [
            'rooms' => $data
        ])->layout('admin::layouts.app', ['title' => "الصفحة الرئيسية"]);
    }
}
