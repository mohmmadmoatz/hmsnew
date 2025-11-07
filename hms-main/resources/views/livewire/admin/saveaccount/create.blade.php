<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">انشاء وصل</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.saveaccount.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Saveaccount')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
            
            <!-- Type Input -->
            <div class='form-group'>
                <label for='inputtype' class='col-sm-2 control-label'> {{ __('Type') }}</label>
                <select wire:model.lazy='type' class="form-control @error('type') is-invalid @enderror">
                    <option value="">نوع العملية</option>
                    <option value="1">ايداع</option>
                    <option value="2">سحب</option>
                </select>
                @error('type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>


            @if($type == 2)
              <!-- wasl Input -->
              <div class='form-group'>
                <label for='inputwasl' class='col-sm-2 control-label'>رقم الوصل</label>
                <input type='number' wire:model.lazy='wasl_number' class="form-control @error('wasl_number') is-invalid @enderror" id='inputwasl'>
                @error('wasl_number') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            @endif
            
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
            
            <!-- Details Input -->
            <div class='form-group'>
                <label for='inputdetails' class='col-sm-2 control-label'> {{ __('Details') }}</label>
                <input type='text' wire:model.lazy='details' class="form-control @error('details') is-invalid @enderror" id='inputdetails'>
                @error('details') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.saveaccount.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
