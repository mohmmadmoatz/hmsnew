<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $floorid;
    protected $queryString = ['search'];

    protected $listeners = ['roomDeleted'];

    public $sortType;
    public $sortColumn;

    public function roomDeleted(){
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
        

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        return view('livewire.admin.room.read', [
            'rooms' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Room')) ]);
    }
}
