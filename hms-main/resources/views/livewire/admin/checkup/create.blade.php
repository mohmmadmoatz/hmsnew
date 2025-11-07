<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">جديد</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.checkup.read')" class="text-decoration-none">العيادة الاستشارية</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
            
            <!-- Patient_id Input -->
            <div class='form-group'>
                <label for='inputpatient_id' class='col-sm-2 control-label'>المريض</label>
                <input type="text" class="form-control" readonly value = "{{App\Models\Patient::find($patient_id)->name ??''}}">
                @error('patient_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <!-- Note Input -->
            <div class='form-group'>
                <label for='inputnote' class='col-sm-2 control-label'> {{ __('Note') }}</label>
                <textarea wire:model.lazy='note' class="form-control @error('note') is-invalid @enderror"></textarea>
                @error('note') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Image Input -->
            <div class='form-group'>
                <label for='inputimage' class='col-sm-2 control-label'> {{ __('Image') }}</label>
                <input type='file' wire:model='image' class="form-control-file @error('image') is-invalid @enderror" id='inputimage'>
                @if($image and !$errors->has('image') and $image instanceof \Livewire\TemporaryUploadedFile and (in_array( $image->guessExtension(), ['png', 'jpg', 'gif', 'jpeg'])))
                    <a href="{{ $image->temporaryUrl() }}"><img width="200" height="200" class="img-fluid shadow" src="{{ $image->temporaryUrl() }}" alt=""></a>
                @endif
                @error('image') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.checkup.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
