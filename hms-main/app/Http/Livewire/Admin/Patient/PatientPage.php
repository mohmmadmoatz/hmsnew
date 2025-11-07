<?php

namespace App\Http\Livewire\Admin\Patient;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class PatientPage extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];

    public function mount()
    {
        // Get search parameter from URL if provided
        $this->search = request('search', '');
    }

    public function render()
    {
        $patients = Patient::query();

        if ($this->search) {
            $patients->where('name', 'like', '%' . $this->search . '%');
        }else{
            $patients->where('id', 0);
        }

        $patients = $patients->with(['stage', 'doctor', 'room', 'croom', 'operation'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        return view('livewire.admin.patient.patient-page', [
            'patients' => $patients
        ])->layout('admin::layouts.app', ['title' => 'صفحة المريض']);
    }
}
