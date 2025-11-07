<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Bank') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.bank.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Bank')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <!-- Wasl_number Input -->
            <div class='form-group'>
                <label for='inputwasl_number' class='col-sm-2 control-label'> {{ __('Wasl_number') }}</label>
                <input type='number' wire:model.lazy='wasl_number' class="form-control @error('wasl_number') is-invalid @enderror" id='inputwasl_number'>
                @error('wasl_number') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Description Input -->
            <div class='form-group'>
                <label for='inputdescription' class='col-sm-2 control-label'> {{ __('Description') }}</label>
                <textarea wire:model.lazy='description' class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Amount_iqd Input -->
            <div class='form-group'>
                <label for='inputamount_iqd' class='col-sm-2 control-label'> {{ __('Amount_iqd') }}</label>
                <input type='number' wire:model.lazy='amount_iqd' class="form-control @error('amount_iqd') is-invalid @enderror" id='inputamount_iqd'>
                @error('amount_iqd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Amount_usd Input -->
            <div class='form-group'>
                <label for='inputamount_usd' class='col-sm-2 control-label'> {{ __('Amount_usd') }}</label>
                <input type='number' wire:model.lazy='amount_usd' class="form-control @error('amount_usd') is-invalid @enderror" id='inputamount_usd'>
                @error('amount_usd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
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
            <a href="@route(getRouteName().'.bank.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
