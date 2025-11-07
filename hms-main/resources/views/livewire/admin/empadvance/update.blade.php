<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Empadvance') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.empadvance.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Empadvance')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <!-- Emp_id Input -->
            <div class='form-group' wire:ignore>
                <label for='inputemp_id' class='col-sm-2 control-label'> {{ __('Emp_id') }}</label>

                <select class="form-control selectpicker" data-live-search="true" wire:model.lazy='emp_id' class="form-control @error('emp_id') is-invalid @enderror" >
                    <option value="">يرجى اختيار الموظف</option>
                    @foreach (App\Models\Employee::all() as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach

                </select>

           
                @error('emp_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Amount Input -->
            <div class='form-group'>
                <label for='inputamount' class='col-sm-2 control-label'>المبلغ</label>
                <input type='text' wire:model.lazy='amount' class="form-control @error('amount') is-invalid @enderror" id='inputamount'>
                @error('amount') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Details Input -->
            <div class='form-group'>
                <label for='inputdetails' class='col-sm-2 control-label'> {{ __('Details') }}</label>
                <input type='text' wire:model.lazy='details' class="form-control @error('details') is-invalid @enderror" id='inputdetails'>
                @error('details') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Date Input -->
            <div class='form-group'>
                <label for='inputdate' class='col-sm-2 control-label'> {{ __('Date') }}</label>
                <input type='date' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror" id='inputdate'>
                @error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.empadvance.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
