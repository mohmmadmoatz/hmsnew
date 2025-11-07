<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('DebitTransaction') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.debittransaction.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('DebitTransaction')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

    <div class="card-body">

        
<div class="row">
    <div class="col-md-12">
        <div class='form-group'>
            <label for='inputpayment_type' class=' control-label'> {{ __('Payment_type') }}</label>
           
            <select class="form-control" wire:model="payment_type">
                
                
                    <option value="1">صرف</option>
                    <option value="2">قبض</option>
              
            </select>
            @error('payment_type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">

     <!-- Account_id Input -->
<div class='form-group' wire:ignore>
    <label for='inputaccount_id' class=' control-label'> {{ __('Account_id') }}</label>
    
   
        <select name='account_id' class='form-control selectpicker' wire:model='account_id' data-live-search="true">
            <option value="">يرجى اختيار الحساب</option>
            @foreach(App\Models\DebitAccount::get() as $account)
                <option value='{{ $account->id }}'>{{ $account->name }}</option>
            @endforeach
        </select>

   
    @error('account_id') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>

    </div>

    <div class="col-md-4">
         <!-- Number Input -->
<div class='form-group'>
    <label for='inputnumber' class=' control-label'> {{ __('رقم القائمة') }}</label>
    <input type='number' wire:model.lazy='number' class="form-control @error('number') is-invalid @enderror" id='inputnumber'>
    @error('number') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
    </div>

    <div class="col-md-4">
<!-- Date Input -->
<div class='form-group'>
<label for='inputdate' class=' control-label'> {{ __('Date') }}</label>
<input type='date' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror" id='inputdate'>
@error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
    </div>

    <div class="col-md-6">
<!-- Amount_iqd Input -->
<div class='form-group'>
<label for='inputamount_iqd' class=' control-label'> {{ __('Amount_iqd') }}</label>
<input type='number' wire:model.lazy='amount_iqd' class="form-control @error('amount_iqd') is-invalid @enderror" id='inputamount_iqd'>
@error('amount_iqd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
    </div>

    <div class="col-md-6">
<!-- Amount_usd Input -->
<div class='form-group'>
<label for='inputamount_usd' class=' control-label'> {{ __('Amount_usd') }}</label>
<input type='number' wire:model.lazy='amount_usd' class="form-control @error('amount_usd') is-invalid @enderror" id='inputamount_usd'>
@error('amount_usd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
    </div>


    <div class="col-md-6">
      <!-- Name Input -->
<div class='form-group'>
    <label for='inputname' class=' control-label'> {{ __('اسم المستلم') }}</label>
    <input type='text' wire:model.lazy='name' class="form-control @error('name') is-invalid @enderror" id='inputname'>
    @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
</div>

    <div class="col-md-6">

<!-- Notes Input -->
<div class='form-group'>
    <label for='inputnotes' class=' control-label'> {{ __('Notes') }}</label>
    <textarea wire:model.lazy='notes' class="form-control @error('notes') is-invalid @enderror"></textarea>
    @error('notes') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>
</div>

<!-- Payment_type Input -->




</div>











<!-- File Input -->
<div class='form-group'>
    <label for='inputfile' class=' control-label'> {{ __('File') }}</label>
    <input type='file' wire:model='file' class="form-control-file @error('file') is-invalid @enderror" id='inputfile'>
    @if($file and !$errors->has('file') and $file instanceof \Livewire\TemporaryUploadedFile and (in_array( $file->guessExtension(), ['png', 'jpg', 'gif', 'jpeg'])))
        <a href="{{ $file->temporaryUrl() }}"><img width="200" height="200" class="img-fluid shadow" src="{{ $file->temporaryUrl() }}" alt=""></a>
    @endif
    @error('file') <div class='invalid-feedback'>{{ $message }}</div> @enderror
</div>



</div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.debittransaction.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
