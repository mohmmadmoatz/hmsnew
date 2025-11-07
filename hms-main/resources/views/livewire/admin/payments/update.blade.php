<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">تعديل السند</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.payments.read')" class="text-decoration-none">السندات</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            <!-- Payment_type Input -->
            <div class='form-group'>
                <label for='inputpayment_type' class=' control-label'>نوع السند</label>
                <select wire:model.lazy='payment_type' class="form-control @error('payment_type') is-invalid @enderror" id='inputpayment_type'>
                <option value="1">صرف</option>
                <option value="2">قبض</option>
                </select>
                @error('payment_type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
            <div class="row">

            <div class="col-md-6">
                    <label for="">رقم الوصل</label>
                    <input type="text" class="form-control" wire:model.lazy="wasl_number">
                </div>

            @if($account_type ==2 && $payment_type==2 && $redirect)
              <div class="col-md-12">
                <label for="">توجيه المريض الى : </label>
                <select class="form-control" wire:model="redirect" wire:change="initDirect">
                    <option value="">اختيار التوجيه</option>
                    @foreach(App\Models\Stage::where("id","!=",5)->get() as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
              </div>
              @endif

                
              @if($operation_id)

              <div class="col-md-6">
                  <div class="form-group">
                        <label for="">النسبة</label>
                        <select class="form-control" wire:model="operation_nsba">
                            <option value="60">60%</option>
                            <option value="40">40%</option>
                        </select>
                  </div>
              </div>

              <div class="col-md-6">
                <div class='form-group'>
                    <label for='inputamount' class=' control-label'>اجور الطبلة</label>
                    <input type='number' wire:model.lazy='operation_profile' class="form-control @error('operation_profile') is-invalid @enderror" id='inputamount'>
                    @error('operation_profile') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class='form-group'>
                    <label for='inputamount' class=' control-label'>اجور العملية</label>
                    <input type='number' wire:model.lazy='operation_price' class="form-control @error('operation_price') is-invalid @enderror" id='inputamount'>
                    @error('operation_price') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                </div>
              </div>

              @endif

                <div class="col-md-6">
                    <div class='form-group'>
                        <label for='inputamount' class=' control-label'>دينار</label>
                        <input type='number' wire:model.lazy='amount_iqd' class="form-control @error('amount_iqd') is-invalid @enderror" id='inputamount'>
                        @error('amount_iqd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                        <!-- Amount Input -->
                <div class='form-group'>
                    <label for='inputamount' class=' control-label'>دولار</label>
                    <input type='number' wire:model.lazy='amount_usd' class="form-control @error('amount_usd') is-invalid @enderror" id='inputamount'>
                    @error('amount_usd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                </div>
    
              
                  </div>

                  @if($redirect)

              

              <div class="col-md-6">
                 
                  <div>
                    <script>
                        $(function () {
        $('.selectpicker2').selectpicker();
        });
                    </script>
                <div class='form-group' wire:ignore>
                    <label for='inputdoctor_id' class=' control-label'>الطبيب</label>
                    
                    <select class="form-control selectpicker2" data-live-search="true" wire:model="redirect_doctor_id" wire:change="changeDoctor">
                        <option value="">يرجى اختيار طبيب</option>
                        @foreach(App\Models\User::where('user_type','resident')->orWhere("user_type","doctor")->orWhere("user_type","rays")->get() as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>

                        @endforeach
                    </select>
                    
                </div>
            </div>
              </div>

                <div class="col-md-6">
                    <label>اجور الطبيب</label>
                    <input type="text" class="form-control" wire:model.lazy="redirect_doctor_price">
                </div>

              @endif
    
                
              </div>
            
            <!-- Description Input -->
            <div class='form-group'>
                <label for='inputdescription' class=' control-label'>وذالك عن</label>
                <textarea wire:model.lazy='description' class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
           
            

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.payments.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
