<?php

namespace App\Http\Livewire\Admin\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Rats\Zkteco\Lib\ZKTeco;
class Core extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $status;
    public $optype;
    public $date;
    protected $queryString = ['search','optype','date'];

   

    public $sortType;
    public $sortColumn;

    

   
    public function render()
    {
        if(!$this->search && !$this->optype && !$this->date){

        
        $zk = new ZKTeco('192.168.1.201','4370');
        $zk->connect();
        $zk->disableDevice();
        $zk->testVoice();
        $users = $zk->getUser();
        $logs = $zk->getAttendance();
     
        $zk->enableDevice();
        $zk->disconnect();
        
        Employee::truncate();
        Employee::insert($users);
        
        Attendance::truncate();
   

        foreach ($logs as $item) {
            Attendance::create([
                "user_id"=>$item['id'],
                "state"=>$item['state'],
                "timestamp"=>$item['timestamp'],
                "date"=> explode(" ",$item['timestamp'])[0],
                "type"=>$item['type']
            ]);
        }
    }
        

        $data = Attendance::query();
        if($this->search){
            $data=$data->where("user_id",$this->search);
        }
        if($this->optype){
            $data=$data->where("type",$this->optype - 1);
        }
        if($this->date){
            $data=$data->where("date",$this->date);
        }
        $data = $data->groupBy("date");
        $data = $data->groupBy("type");
        $data = $data->groupBy("user_id");

        $data= $data->paginate(10);
        return view('livewire.admin.attendance.logs', [
            'data' => $data
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Patient')) ]);
    }
}
