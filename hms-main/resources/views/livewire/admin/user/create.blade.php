<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('CreateTitle', ['name' => __('User') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.user.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('User')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
            
            <!-- Name Input -->
            <div class='form-group'>
                <label for='inputname' class='col-sm-2 control-label'> {{ __('Name') }}</label>
                <input type='text' wire:model.lazy='name' class="form-control @error('name') is-invalid @enderror" id='inputname'>
                @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Email Input -->
            <div class='form-group'>
                <label for='inputemail' class='col-sm-2 control-label'> {{ __('Email') }}</label>
                <input type='text' wire:model.lazy='email' class="form-control @error('email') is-invalid @enderror" id='inputemail'>
                @error('email') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <div class='form-group'>
                <label for='phone' class='col-sm-2 control-label'> {{ __('رقم الواتس اب') }}</label>
                <input type='text' wire:model.lazy='phone' class="form-control @error('phone') is-invalid @enderror" id='phone'>
                @error('phone') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Password Input -->
            <div class='form-group'>
                <label for='inputpassword' class='col-sm-2 control-label'> {{ __('Password') }}</label>
                <input type='text' wire:model.lazy='password' class="form-control @error('password') is-invalid @enderror" id='inputpassword'>
                @error('password') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Image Input -->
            <div class='form-group'>
                <label for='inputgender' class='col-sm-2 control-label'> {{ __('User Type') }}</label>
         
                <select wire:model = "user_type" class="form-control">
                                    <option value="">Select User Type</option>
                                 
                                    <option value="superadmin">superadmin</option>
                                    <option value="accountant">accountant</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="resident">مقيمة</option>
                                    <option value="info">Information</option>
                                    <option value="lab">lab</option>
                                    <option value="rays">rays</option>
                                    <option value="sonar">sonar</option>
                                    <option value="tabq">طابق</option>
                                    <option value="stockmanagment">مخزن</option>
                                    <option value="operation">عمليات</option>
                                    <option value="investor">مستثمر</option>

                                </select>
            </div>

            <div class='form-group'>
                <label for='inputimage' class='col-sm-2 control-label'> {{ __('Image') }}</label>
                <input type='file' wire:model='image' class="form-control-file @error('image') is-invalid @enderror" id='inputimage'>
                @if($image and !$errors->has('image') and $image instanceof \Livewire\TemporaryUploadedFile and (in_array( $image->guessExtension(), ['png', 'jpg', 'gif', 'jpeg'])))
                    <a href="{{ $image->temporaryUrl() }}"><img width="200" height="200" class="img-fluid shadow" src="{{ $image->temporaryUrl() }}" alt=""></a>
                @endif
                @error('image') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <!-- is_second -->
            <div class='form-group'>
                <label for='inputis_second' class='col-sm-2 control-label'> {{ __('Is Second') }}</label>
                <input type='checkbox' wire:model.lazy='is_second' class="form-control @error('is_second') is-invalid @enderror" id='inputis_second'>
                @error('is_second') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                <small class="text-muted">{{ __('Is Second Help') }}</small>
</div>
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.user.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
