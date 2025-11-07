<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('احصائيات المختبر') }}</h3>

                <div class="px-2 mt-4">
                 

                    <!-- Date Range Filter -->
                    <div class="row justify-content-center mt-4 mb-4">
                        <div class="col-md-3">
                            <label for="dateFrom">{{ __('من تاريخ') }}</label>
                            <input type="date" class="form-control" wire:model="dateFrom" id="dateFrom">
                        </div>
                        <div class="col-md-3">
                            <label for="dateTo">{{ __('إلى تاريخ') }}</label>
                            <input type="date" class="form-control" wire:model="dateTo" id="dateTo">
                        </div>
                        <div class="col-md-3">
                            <label for="period">{{ __('الفترة') }}</label>
                            <select class="form-control" wire:model="period" id="period">
                                <option value="day">{{ __('يومي') }}</option>
                                <option value="week">{{ __('أسبوعي') }}</option>
                                <option value="month">{{ __('شهري') }}</option>
                                <option value="year">{{ __('سنوي') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary" wire:click="loadStatistics">{{ __('تحديث الإحصائيات') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner text-white">
                                <h3>{{ number_format($totalLabs) }}</h3>
                                <p>{{ __('إجمالي الفحوصات') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-flask text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner text-white">
                                <h3>{{ number_format($totalTests) }}</h3>
                                <p>{{ __('إجمالي الاختبارات') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-vial text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner text-white">
                                <h3>{{ number_format($totalPatients) }}</h3>
                                <p>{{ __('إجمالي المرضى') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner text-white">
                                <h3>{{ $avgTestsPerLab }}</h3>
                                <p>{{ __('متوسط الاختبارات لكل فحص') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Tests by Category Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('الاختبارات حسب الفئة') }}</h5>
                            </div>
                            <div class="card-body">
                                @if(count($testsByCategory) > 0)
                                    <canvas id="categoryChart" width="400" height="300"></canvas>
                                @else
                                    <p class="text-center text-muted">{{ __('لا توجد بيانات متاحة') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Patient Gender Distribution -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('توزيع المرضى حسب الجنس') }}</h5>
                            </div>
                            <div class="card-body">
                                @if(count($patientGenderStats) > 0)
                                    <canvas id="genderChart" width="400" height="300"></canvas>
                                @else
                                    <p class="text-center text-muted">{{ __('لا توجد بيانات متاحة') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

               

                <!-- Most Common Tests -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('أكثر الاختبارات شيوعاً') }}</h5>
                            </div>
                            <div class="card-body">
                                @if(count($mostCommonTests) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('الاختبار') }}</th>
                                                    <th>{{ __('العدد') }}</th>
                                                    <th>{{ __('النسبة') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mostCommonTests as $test)
                                                    <tr>
                                                        <td>{{ $test['name'] }}</td>
                                                        <td>{{ number_format($test['count']) }}</td>
                                                        <td>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{ ($test['count'] / max(array_column($mostCommonTests, 'count'))) * 100 }}%"
                                                                     aria-valuenow="{{ $test['count'] }}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="{{ max(array_column($mostCommonTests, 'count')) }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center text-muted">{{ __('لا توجد بيانات متاحة') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Labs by Date Table -->
                @if(count($labsByDate) > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('الفحوصات حسب التاريخ') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('التاريخ') }}</th>
                                                <th>{{ __('عدد الفحوصات') }}</th>
                                                <th>{{ __('النسبة') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($labsByDate as $date => $count)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</td>
                                                    <td>{{ number_format($count) }}</td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                 style="width: {{ ($count / max($labsByDate)) * 100 }}%"
                                                                 aria-valuenow="{{ $count }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="{{ max($labsByDate) }}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Global chart instances
let categoryChart = null;
let genderChart = null;
let trendChart = null;

function initCharts() {
    // Destroy existing charts
    if (categoryChart) {
        categoryChart.destroy();
        categoryChart = null;
    }
    if (genderChart) {
        genderChart.destroy();
        genderChart = null;
    }
    if (trendChart) {
        trendChart.destroy();
        trendChart = null;
    }

    // Category Chart
    @if(count($testsByCategory) > 0)
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($testsByCategory)),
                datasets: [{
                    data: @json(array_values($testsByCategory)),
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FF6384',
                        '#C9CBCF'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
    @endif

    // Gender Chart
    @if(count($patientGenderStats) > 0)
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        genderChart = new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($patientGenderStats)),
                datasets: [{
                    data: @json(array_values($patientGenderStats)),
                    backgroundColor: ['#FF6384', '#36A2EB'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
    @endif

    // Trend Chart
    
}

// Initialize charts on page load
document.addEventListener('livewire:load', function () {
    initCharts();
});

// Re-initialize charts when Livewire updates the component
document.addEventListener('livewire:updated', function () {
    setTimeout(() => {
        initCharts();
    }, 100);
});
</script>


