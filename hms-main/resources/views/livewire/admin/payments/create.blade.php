<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">انشاء سند جديد</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.payments.read')" class="text-decoration-none">الحسابات</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body" x-data="{'account_type':@entangle('account_type')}">

            <div class="row">
                <div class="col-md-6">
                    <label for="">رقم الوصل</label>
                    <input type="text" class="form-control" wire:model.lazy="wasl_number">
                </div>

                <div class="col-md-6">
                    <label for="">التاريخ</label>
                    <input  type="date" class="form-control" wire:model.lazy="date">
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>نوع الحساب</label>
                        <select @if($daterange) disabled @endif class="form-control @error('account_type') is-invalid @enderror" wire:model.lazy="account_type">
                                <option value="">يرجى اختيار نوع الحساب</option>
                                <option value="1">طبيب</option>
                                <option value="2">مريض</option>
                                <option value="3">نقدي</option>
                        </select>
                        @error('account_type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="col-md-6" wire:ignore x-show="account_type ==1">
                    <div class='form-group'>
                        <label for='inputdoctor_id' class=' control-label'>الطبيب</label>
                        
                        <select @if($daterange) disabled @endif  class="form-control selectpicker" data-live-search="true" wire:model="account_id">
                            <option value="">يرجى اختيار طبيب</option>
                            @foreach(App\Models\User::where('user_type','doctor')->orWhere("user_type","resident")->get() as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
    
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="col-md-6"  x-show="account_type ==2">
                    <div class='form-group'>
                      
                        
                    @if($patinet_id) 
                       <label for='name' class='control-label'> {{ __('المريض') }}</label>
                        <input readonly @if($patinet_id) disabled @endif  type='text' value="{{App\Models\Patient::find($patinet_id)->name}}"
                            class="form-control @error('name') is-invalid @enderror" id='name'>
                            <a href="#cancel" wire:click="clear()" class="btn btn-danger">الغاء</a>
                        @error('phone') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                        @else
                        @include('livewire.admin.widget.selectpat',['model'=>"searchpat"])
                        @endif

                    
                        
                        
                    </div>
                </div>

                <div class="col-md-6" wire:ignore x-show="account_type ==3">
                    <div class='form-group'>
                        <label for='inputdoctor_id' class=' control-label'>الأسم</label>
                        <select @if($daterange && !$stname) readonly @endif  type="text" class="form-control" wire:model.lazy = "account_id">
                            <option value="">يرجى الأختيار</option>
                            @foreach(App\Models\Cashaccount::get() as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach

                        </select>

                    </div>
                </div>
       

            </div>
            
            <!-- Payment_type Input -->
            <div class='form-group'>
                <label for='inputpayment_type' class='col-sm-2 control-label'>نوع السند</label>
                <select @if($daterange) disabled @endif @if($patinet_id) disabled @endif wire:model.lazy='payment_type' class="form-control @error('payment_type') is-invalid @enderror" id='inputpayment_type'>
                <option value="1">صرف</option>
                <option value="2">قبض</option>
                </select>
                @if($payment_type == 1 && $account_type == "2")
                <input type="checkbox" wire:model="return_price">مبلغ مسترجع ؟
                @elseif($payment_type ==2 && $account_type =="2")
                <input type="checkbox" wire:model="return_price">مبلغ مضاف ؟
                @endif
                @error('payment_type') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            @if($return_price)
                <div class="form-group">
                    <label for="">رقم الوصل</label>
                    <input type="number" class="form-control" wire:model.lazy="return_id">
                </div>
            @endif
            
            
          <div class="row">
              @if($total_amount)
              <div class="col-md-12">
                  <label for="">اجمالي المبلغ</label>
                  <input type="text" readonly class="form-control" value="@convert($total_amount)">
              </div>
              @endif
              @if($account_type ==2 && $payment_type==2)
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
            <div class="col-md-6">
                <div class='form-group'>
                    <label for='inputamount' class='col-sm-2 control-label'>دينار</label>
                    <input type='text' wire:model.lazy='amount_iqd' class="currency-mask form-control @error('amount_iqd') is-invalid @enderror" id='inputamount'>
                    @error('amount_iqd') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                    <!-- Amount Input -->
            <div class='form-group'>
                <label for='inputamount' class='col-sm-2 control-label'>دولار</label>
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
                <label for='inputdescription' class='col-sm-2 control-label'>وذالك عن</label>
                <textarea wire:model.lazy='description' class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            
           
            
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <button wire:click.prevent= "create(1)" class="btn btn-info ml-4">{{ __('انشاء وطباعة') }}</button>
            <a href="@route(getRouteName().'.payments.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
