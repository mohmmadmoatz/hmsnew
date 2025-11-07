<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">تحديث الملاحظات</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.followup.read')" class="text-decoration-none">ملاحظات الممرضة والعلاج</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

    <div class="card-body">

<div class="row">
    <div class="col-md-4">
        <!-- Bp Input -->
        <div class='form-group'>
            <label for='inputbp' class=' control-label'> {{ __('Bp') }}</label>
            <input type='text' wire:model.lazy='bp' class="form-control @error('bp') is-invalid @enderror"
                id='inputbp'>
            @error('bp') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <!-- Pr Input -->
        <div class='form-group'>
            <label for='inputpr' class=' control-label'> {{ __('Pr') }}</label>
            <input type='text' wire:model.lazy='pr' class="form-control @error('pr') is-invalid @enderror"
                id='inputpr'>
            @error('pr') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-4">
        <!-- Drain Input -->
        <div class='form-group'>
            <label for='inputdrain' class=' control-label'> {{ __('Drain') }}</label>
            <input type='text' wire:model.lazy='drain'
                class="form-control @error('drain') is-invalid @enderror" id='inputdrain'>
            @error('drain') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <!-- Itake Input -->
        <div class='form-group'>
            <label for='inputitake' class=' control-label'> {{ __('Itake') }}</label>
            <input type='text' wire:model.lazy='itake'
                class="form-control @error('itake') is-invalid @enderror" id='inputitake'>
            @error('itake') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <!-- Spo2 Input -->
        <div class='form-group'>
            <label for='inputspo2' class=' control-label'> {{ __('Spo2') }}</label>
            <input type='text' wire:model.lazy='spo2'
                class="form-control @error('spo2') is-invalid @enderror" id='inputspo2'>
            @error('spo2') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <!-- Temp Input -->
        <div class='form-group'>
            <label for='inputTemp' class=' control-label'> {{ __('Temp') }}</label>
            <input type='text' wire:model.lazy='Temp'
                class="form-control @error('Temp') is-invalid @enderror" id='inputTemp'>
            @error('Temp') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-4">
                    <!-- Temp Input -->
                    <div class='form-group'>
                        <label for='output' class=' control-label'> {{ __('Out.put') }}</label>
                        <input type='text' wire:model.lazy='output'
                            class="form-control @error('output') is-invalid @enderror" id='output'>
                        @error('output') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>
                </div>
</div>













<!-- Treatment Input -->
<div class='form-group'>
    <label for='inputtreatment' class=' control-label'> {{ __('Treatment') }}</label>
    <input type='text' wire:model.lazy='treatment'
        class="form-control @error('treatment') is-invalid @enderror" id='inputtreatment'>
    @error('treatment') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>

<!-- Pat_id Input -->
<div class='form-group' wire:ignore>
    <label for='inputpat_id' class=' control-label'> {{ __('المريض') }}</label>
    <select wire:model.lazy="pat_id" class="form-control selectpicker" data-live-search="true">
        <option value="">فلترة حسب المريض</option>
        @foreach(App\Models\Patient::latest()->get() as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
    </select>
    @error('pat_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>

<!-- Date Input -->
<div class='form-group'>
    <label for='inputdate' class=' control-label'> {{ __('Date') }}</label>
    
    <input type='date' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror"
        id='inputdate'>
    @error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>

</div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.followup.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
