<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">انشاء توجيه جديد</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.stage.read')" class="text-decoration-none">التوجيهات</a></li>
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
            
            <div wire:ignore>
                <div class='form-group'>
                    <label for='inputdoctor_id' class=' control-label'>الطبيب</label>
                    
                    <select class="form-control selectpicker" data-live-search="true" wire:model="doctor_id">
                        <option value="">يرجى اختيار طبيب</option>
                        @foreach(App\Models\User::where('user_type','resident')->orWhere("user_type","doctor")->get() as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>

                        @endforeach
                    </select>
                    
                </div>
            </div>
            
            <!-- Total_price Input -->
            <div class='form-group'>
                <label for='inputtotal_price' class='col-sm-2 control-label'> {{ __('اجمالي المبلغ') }}</label>
                <input type='number' wire:model.lazy='total_price' class="form-control @error('total_price') is-invalid @enderror" id='inputtotal_price'>
                @error('total_price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Doctor_price Input -->
            <div class='form-group'>
                <label for='inputdoctor_price' class='col-sm-2 control-label'> {{ __('اجور الطبيب') }}</label>
                <input type='number' wire:model.lazy='doctor_price' class="form-control @error('doctor_price') is-invalid @enderror" id='inputdoctor_price'>
                @error('doctor_price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

              <!-- other Input -->
              <div class='form-group'>
                <label for='inputdoctor_price' class='col-sm-2 control-label'> {{ __('اجور الممرضة') }}</label>
                <input type='number' wire:model.lazy='other_price' class="form-control @error('other_price') is-invalid @enderror" id='inputdoctor_price'>
                @error('other_price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <!-- other Input -->
            <div class='form-group'>
                <label for='inputdoctor_price' class='col-sm-2 control-label'> {{ __('اجور المقيم') }}</label>
                <input type='number' wire:model.lazy='res_price' class="form-control @error('res_price') is-invalid @enderror" id='inputdoctor_price'>
                @error('res_price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.stage.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
