<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Opostpond') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.opostpond.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Opostpond')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <!-- Operationhold_id Input -->
            <div class='form-group'>
                <label for='inputoperationhold_id' class='col-sm-2 control-label'> {{ __('Operationhold_id') }}</label>
                <input type='number' wire:model.lazy='operationhold_id' class="form-control @error('operationhold_id') is-invalid @enderror" id='inputoperationhold_id'>
                @error('operationhold_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Date Input -->
            <div class='form-group'>
                <label for='inputdate' class='col-sm-2 control-label'> {{ __('Date') }}</label>
                <input type='text' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror" id='inputdate'>
                @error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Reason Input -->
            <div class='form-group'>
                <label for='inputreason' class='col-sm-2 control-label'> {{ __('Reason') }}</label>
                <textarea wire:model.lazy='reason' class="form-control @error('reason') is-invalid @enderror"></textarea>
                @error('reason') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.opostpond.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
