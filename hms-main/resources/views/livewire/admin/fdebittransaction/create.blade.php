<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">انشاء</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.fdebittransaction.read')" class="text-decoration-none">وصل صرف (ديون ثابتة)</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id">{{ __('Category_id') }}</label>
                        <select wire:model="category_id" class="form-control" id="category_id" name="category_id">
                            <option value="">اختيار</option>
                            @foreach(App\Models\FdebitCategory::get() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class='form-group'>
                        <label for='inputnumber' class=' control-label'> {{ __('Number') }}</label>
                        <input type='text' wire:model.lazy='number' class="form-control @error('number') is-invalid @enderror" id='inputnumber'>
                        @error('number') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="col-md-4">
  <!-- Name Input -->
  <div class='form-group'>
    <label for='inputname' class=' control-label'> {{ __('اسم المستلم') }}</label>
    <input type='text' wire:model.lazy='name' class="form-control @error('name') is-invalid @enderror" id='inputname'>
    @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
                </div>


                <div class="col-md-4">
  <!-- Amount_iqd Input -->
  <div class='form-group'>
    <label for='inputamount_iqd' class=' control-label'> {{ __('Amount_iqd') }}</label>
    <input type='number' wire:model.lazy='amount_iqd' class="form-control @error('amount_iqd') is-invalid @enderror" id='inputamount_iqd'>
    @error('amount_iqd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
                </div>

                <div class="col-md-4">
 <!-- Amount_usd Input -->
 <div class='form-group'>
    <label for='inputamount_usd' class=' control-label'> {{ __('Amount_usd') }}</label>
    <input type='number' wire:model.lazy='amount_usd' class="form-control @error('amount_usd') is-invalid @enderror" id='inputamount_usd'>
    @error('amount_usd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
                </div>

                <div class="col-md-4">
   <!-- Exchange_rate Input -->
   <div class='form-group'>
    <label for='inputexchange_rate' class=' control-label'> {{ __('Exchange_rate') }}</label>
    <input type='text' wire:model.lazy='exchange_rate' class="form-control @error('exchange_rate') is-invalid @enderror" id='inputexchange_rate'>
    @error('exchange_rate') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
                </div>

                <div class="col-md-6">
  <!-- Notes Input -->
  <div class='form-group'>
    <label for='inputnotes' class=' control-label'> {{ __('Notes') }}</label>
    <input type='text' wire:model.lazy='notes' class="form-control @error('notes') is-invalid @enderror" id='inputnotes'>
    @error('notes') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
                </div>

                <div class="col-md-6">

                       
            <!-- Date Input -->
            <div class='form-group'>
                <label for='inputdate' class=' control-label'> {{ __('Date') }}</label>
                <input type='date' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror" id='inputdate'>
                @error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

                </div>

            </div>
            
           
           
            
          
            
          
            
           
            
         
            
          
         
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.fdebittransaction.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
