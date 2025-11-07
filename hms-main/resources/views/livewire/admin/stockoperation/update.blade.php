<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Stockoperation') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.stockoperation.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Stockoperation')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <!-- Op_type Input -->
            <div class='form-group'>
                <label for='inputop_type' class='col-sm-2 control-label'> {{ __('Op_type') }}</label>
                <input type='text' wire:model.lazy='op_type' class="form-control @error('op_type') is-invalid @enderror" id='inputop_type'>
                @error('op_type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Product_id Input -->
            <div class='form-group'>
                <label for='inputproduct_id' class='col-sm-2 control-label'> {{ __('Product_id') }}</label>
                <input type='text' wire:model.lazy='product_id' class="form-control @error('product_id') is-invalid @enderror" id='inputproduct_id'>
                @error('product_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- To_person Input -->
            <div class='form-group'>
                <label for='inputto_person' class='col-sm-2 control-label'> {{ __('To_person') }}</label>
                <input type='text' wire:model.lazy='to_person' class="form-control @error('to_person') is-invalid @enderror" id='inputto_person'>
                @error('to_person') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- To_department Input -->
            <div class='form-group'>
                <label for='inputto_department' class='col-sm-2 control-label'> {{ __('To_department') }}</label>
                <input type='text' wire:model.lazy='to_department' class="form-control @error('to_department') is-invalid @enderror" id='inputto_department'>
                @error('to_department') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Price Input -->
            <div class='form-group'>
                <label for='inputprice' class='col-sm-2 control-label'> {{ __('Price') }}</label>
                <input type='text' wire:model.lazy='price' class="form-control @error('price') is-invalid @enderror" id='inputprice'>
                @error('price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <!-- Notes Input -->
            <div class='form-group'>
                <label for='inputnotes' class='col-sm-2 control-label'> {{ __('Notes') }}</label>
                <textarea wire:model.lazy='notes' class="form-control @error('notes') is-invalid @enderror"></textarea>
                @error('notes') <div class='invalid-feedback'>{{ $message }}</div> @enderror
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
            
            <!-- Qty Input -->
            <div class='form-group'>
                <label for='inputqty' class='col-sm-2 control-label'> {{ __('Qty') }}</label>
                <input type='text' wire:model.lazy='qty' class="form-control @error('qty') is-invalid @enderror" id='inputqty'>
                @error('qty') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.stockoperation.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
