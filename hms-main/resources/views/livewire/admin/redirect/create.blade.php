<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('CreateTitle', ['name' => __('Redirect') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.redirect.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Redirect')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
            
            <!-- Pat_id Input -->
            <div class='form-group'>
                
                @include('livewire.admin.widget.selectpat',['model'=>"pat_id"])

                @error('pat_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Redirect_id Input -->
            <div class='form-group'>
                <label for='inputredirect_id' class='col-sm-2 control-label'> {{ __('Redirect_id') }}</label>
                <input type='number' wire:model.lazy='redirect_id' class="form-control @error('redirect_id') is-invalid @enderror" id='inputredirect_id'>
                @error('redirect_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Redirect_doctor_id Input -->
            <div class='form-group'>
                <label for='inputredirect_doctor_id' class='col-sm-2 control-label'> {{ __('Redirect_doctor_id') }}</label>
                <input type='number' wire:model.lazy='redirect_doctor_id' class="form-control @error('redirect_doctor_id') is-invalid @enderror" id='inputredirect_doctor_id'>
                @error('redirect_doctor_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.redirect.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
