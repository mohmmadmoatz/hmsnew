<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Warehouse') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.warehouse.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Warehouse')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <!-- Supplier_name Input -->
                    <div class='form-group' wire:ignore>
                        <label for='inputsupplier_name' class=' control-label'>
                            {{ __('اسم المندوب او الشركة') }}</label>

                            <select data-live-search="true" class="selectpicker form-control @error('supplier_name') is-invalid @enderror" id='inputsupplier_name'  wire:model.lazy='supplier_name'>
                                <option value=""></option>
                                @foreach(App\Models\Stocksup::where("type","شركة")->get() as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>

                                @endforeach
                            </select>

                        
                        @error('supplier_name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="col-md-4">
                        <!-- Date Input -->
            <div class='form-group'>
                <label for='inputdate' class=' control-label'> {{ __('Date') }}</label>
                <input type='date' wire:model.lazy='date' class="form-control @error('date') is-invalid @enderror"
                    id='inputdate'>
                @error('date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
                </div>


                <div class="col-md-4">
                      <!-- Menu_no Input -->
            <div class='form-group'>
                <label for='inputmenu_no' class=' control-label'> {{ __('Menu_no') }}</label>
                <input type='text' wire:model.lazy='menu_no' class="form-control @error('menu_no') is-invalid @enderror"
                    id='inputmenu_no'>
                @error('menu_no') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
                </div>

                <div class="col-md-6">
                        <!-- Phone Input -->
            <div class='form-group'>
                <label for='inputphone' class=' control-label'> {{ __('Phone') }}</label>
                <input type='number' wire:model.lazy='phone' class="form-control @error('phone') is-invalid @enderror"
                    id='inputphone'>
                @error('phone') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
                </div>

                <div class="col-md-6">
    

            <!-- Address Input -->
            <div class='form-group'>
                <label for='inputaddress' class=' control-label'> {{ __('Address') }}</label>
                <textarea wire:model.lazy='address'
                    class="form-control @error('address') is-invalid @enderror"></textarea>
                @error('address') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
                </div>

            </div>

            <hr>
            
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>اسم المادة</th>
                        <th>السعر</th>
                        <th>الوحدة</th>
                        <th>العدد</th>
                        <th>الأجمالي</th>
                        <th></th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td wire:ignore>
                            <select class="form-control selectpicker" wire:model.lazy="item" data-live-search="true" wire:change="selectitem">
                                <option value="">يرجى اختيار المادة</option>
                                 @foreach(App\Models\Warehouseproduct::get() as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                 @endforeach
                            </select>
                        </td>
                        <td><input type="number" class="form-control" wire:model="amount"></td>
                        <td>
                            <select class="form-control" wire:model="unit">
                                <option value="">{{App\Models\UnitConv::where("product_id",$productID)->first()->base->name ?? "قطعة"}}</option>

                                @foreach(App\Models\UnitConv::where("product_id",$productID)->get() as $item)
                                    <option value="{{$item->id}}">{{$item->unit->name}} ({{$item->factor}})</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" class="form-control" wire:model="qtyInput">
                        @if($unit)
                             {{App\Models\UnitConv::where("id",$unit)->first()->base->name ?? ""}} : {{(App\Models\UnitConv::where("id",$unit)->first()->factor ?? 1) * ($qtyInput == ""? 1 : $qtyInput)}}
                            @endif

                    </td>
                        <td><input readonly type="number" class="form-control" wire:model="total"></td>
                        <td>
                            <a href="#addPlus" wire:click="addItem()" class="btn btn-info"><i class="fa fa-plus"></i></a>
                        </td>
                    </tr>
                    @foreach($items as $item)
                    <tr>

                    
                    <td>{{$item['productname']}}</td>
                    <td>@convert($item['amount'])</td>
                    
                    <td>

                    @php
                    $convID =App\Models\UnitConv::find($item['unit']);
                    if($convID){
                        $unitname = App\Models\Unit::find($convID->unit_id)->name;
                    }
                  

                    @endphp
                    {{$item['qtyinput']}}
                    (
                        {{ $unitname ??"قطعة"}}
                    
                    )

                    </td>

                    <td>
                        
                    {{$item['qty']}}  قطعة
             
                   

                    </td>
                    <td>@convert($item['total'])</td>
                    <td>
                        <a href="#delete" class="btn btn-danger" wire:click="deleteItem({{$loop->index}})"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>



            

          

        

            <!-- Image Input -->
            <div class='form-group'>
                <label for='inputimage' class=' control-label'> {{ __('صورة القائمة') }}</label>
                <input type='file' wire:model='image' class="form-control-file @error('image') is-invalid @enderror"
                    id='inputimage'>
                @if($image and !$errors->has('image') and $image instanceof \Livewire\TemporaryUploadedFile and
                (in_array( $image->guessExtension(), ['png', 'jpg', 'gif', 'jpeg'])))
                <a href="{{ $image->temporaryUrl() }}"><img width="200" height="200" class="img-fluid shadow"
                        src="{{ $image->temporaryUrl() }}" alt=""></a>
                @endif
                @error('image') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>اجمالي القائمة</label>
                <input type="text"  class="form-control" readonly value="@convert($totalmenu)">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.warehouse.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
