<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Lab;
use App\Models\PatTests;
use App\Models\PatTestComponet;
use App\Models\LabTest;
use App\Models\LabCategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Carbon\Carbon;

class LabStatistics extends Component
{
    public $dateFrom;
    public $dateTo;
    public $period = 'month'; // day, week, month, year

    public $totalLabs;
    public $totalTests;
    public $totalPatients;
    public $avgTestsPerLab;

    public $labsByDate = [];
    public $testsByCategory = [];
    public $mostCommonTests = [];
    public $patientGenderStats = [];

    public $topCategories = [];
    public $trends = [];

    protected function applyIsSecondFilter($query)
    {
        // For now, don't filter by is_second to ensure data is visible
        // TODO: Fix this filtering based on user authentication
        return $query;
    }

    public function mount()
    {
        // Set default to July 2024 which has the most data (1447 labs)
        $this->dateFrom = '2024-07-01';
        $this->dateTo = '2024-07-31';
        $this->loadStatistics();
    }

    public function updatedDateFrom()
    {
        $this->loadStatistics();
    }

    public function updatedDateTo()
    {
        $this->loadStatistics();
    }

    public function updatedPeriod()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $query = $this->applyIsSecondFilter(Lab::query())
            ->whereBetween('created_at', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ]);

        // Basic Statistics
        $this->totalLabs = $query->count();
        $this->totalTests = PatTests::whereHas('lab', function($q) {
            $q->where('is_second', auth()->user()->is_second ?? null)
              ->whereBetween('created_at', [
                  Carbon::parse($this->dateFrom)->startOfDay(),
                  Carbon::parse($this->dateTo)->endOfDay()
              ]);
        })->count();

        $this->totalPatients = $query->distinct('patient_id')->count();

        $this->avgTestsPerLab = $this->totalLabs > 0 ? round($this->totalTests / $this->totalLabs, 2) : 0;

        // Labs by Date
        $this->labsByDate = $this->applyIsSecondFilter(Lab::query())
            ->whereBetween('created_at', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->selectRaw('DATE(labs.created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Tests by Category
        $this->testsByCategory = PatTests::join('lab_tests', 'pat_tests.test_id', '=', 'lab_tests.id')
            ->join('lab_categories', 'lab_tests.category_id', '=', 'lab_categories.id')
            ->whereHas('lab', function($q) {
                $q->where('is_second', auth()->user()->is_second ?? null)
                  ->whereBetween('created_at', [
                      Carbon::parse($this->dateFrom)->startOfDay(),
                      Carbon::parse($this->dateTo)->endOfDay()
                  ]);
            })
            ->selectRaw('lab_categories.name as category, COUNT(*) as count')
            ->groupBy('lab_categories.id', 'lab_categories.name')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // Most Common Tests
        $this->mostCommonTests = PatTests::join('lab_tests', 'pat_tests.test_id', '=', 'lab_tests.id')
            ->whereHas('lab', function($q) {
                $q->where('is_second', auth()->user()->is_second ?? null)
                  ->whereBetween('created_at', [
                      Carbon::parse($this->dateFrom)->startOfDay(),
                      Carbon::parse($this->dateTo)->endOfDay()
                  ]);
            })
            ->selectRaw('lab_tests.name, COUNT(*) as count')
            ->groupBy('lab_tests.id', 'lab_tests.name')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->toArray();

        // Patient Gender Statistics
        $this->patientGenderStats = $this->applyIsSecondFilter(Lab::query())
            ->whereBetween('labs.created_at', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->join('patients', 'labs.patient_id', '=', 'patients.id')
            ->selectRaw('patients.gender, COUNT(*) as count')
            ->groupBy('patients.gender')
            ->get()
            ->pluck('count', 'gender')
            ->toArray();


        // Top Categories
        $this->topCategories = collect($this->testsByCategory)->sortDesc()->take(5)->toArray();

        // Trends based on period
        $this->loadTrends();
    }

    public function loadTrends()
    {
        $query = $this->applyIsSecondFilter(Lab::query())
            ->whereBetween('created_at', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ]);

        switch($this->period) {
            case 'day':
                $this->trends = $query->selectRaw('DATE(labs.created_at) as period, COUNT(*) as count')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get()
                    ->pluck('count', 'period')
                    ->toArray();
                break;

            case 'week':
                $this->trends = $query->selectRaw('YEAR(labs.created_at) as year, WEEK(labs.created_at) as week, COUNT(*) as count')
                    ->groupBy('year', 'week')
                    ->orderBy('year')
                    ->orderBy('week')
                    ->get()
                    ->mapWithKeys(function($item) {
                        return ["{$item->year}-W{$item->week}" => $item->count];
                    })
                    ->toArray();
                break;

            case 'month':
                $this->trends = $query->selectRaw('YEAR(labs.created_at) as year, MONTH(labs.created_at) as month, COUNT(*) as count')
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get()
                    ->mapWithKeys(function($item) {
                        return ["{$item->year}-{$item->month}" => $item->count];
                    })
                    ->toArray();
                break;

            case 'year':
                $this->trends = $query->selectRaw('YEAR(labs.created_at) as year, COUNT(*) as count')
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get()
                    ->pluck('count', 'year')
                    ->toArray();
                break;
        }
    }

    public function render()
    {
        return view('livewire.admin.lab.lab-statistics')
            ->layout('admin::layouts.app', ['title' => __('احصائيات المختبر') ]);
    }
}
