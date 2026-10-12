<?php

namespace App\Http\Livewire\Admin\Operationhold;

use App\Models\OperationHold;
use Livewire\Component;

// اطباء التخدير للعملية (ممكن اكثر من طبيب)
class Anesthesia extends Component
{
    public $opid;
    public $names = [];
    public $newName = "";

    public function mount($opid)
    {
        $this->opid = $opid;
        $this->names = OperationHold::find($opid)->anesthesia_doctors ?? [];
    }

    public function add()
    {
        $name = trim(preg_replace('/\s+/u', ' ', $this->newName));
        if ($name === "") {
            return;
        }

        if (!in_array($name, $this->names)) {
            $this->names[] = $name;
            $this->save();
        }

        $this->newName = "";
    }

    public function remove($index)
    {
        array_splice($this->names, $index, 1);
        $this->save();
    }

    private function save()
    {
        $op = OperationHold::find($this->opid);
        $op->anesthesia_doctors = count($this->names) ? array_values($this->names) : null;
        $op->save();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => "تم حفظ اطباء التخدير"]);
    }

    public function render()
    {
        return view('livewire.admin.operationhold.anesthesia');
    }
}
