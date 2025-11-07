<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">مصاريف العملية</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')"
                        class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.warehouseexport.read')"
                        class="text-decoration-none">مصاريف العملية</a></li>
                <li class="breadcrumb-item active">انشاء</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <!-- Name Input -->
                    <div class='form-group' wire:ignore>
                        <label for='inputname' class=' control-label'>القسم</label>
                        <select data-live-search="true" class="selectpicker form-control @error('name') is-invalid @enderror" id='name'  wire:model.lazy='name'>
                            <option value=""></option>
                            @foreach(App\Models\Stocksup::where("type","قسم")->get() as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
           

                <div class="col-md-3">
                    <!-- Name Input -->
                    <div class='form-group' wire:ignore>
                        <label for='inputname' class=' control-label'>رقم الوصل</label>
                        <input type="text" class="form-control" readonly value="{{$opinfo->payment_number}}">
                    </div>
                </div>
           

                <div class="col-md-3">
                     <!-- Date Input -->
            <div class='form-group'>
                <label for='inputdate' class=' control-label'>المريض</label>
                <input type="text" class="form-control" readonly value="{{$opinfo->Patient->name}}">
            </div>
                </div>

                <div class="col-md-3">
                    <label for="">رقم القائمة</label>
                    <input type="text" class="form-control">
                </div>
           
                <div class="col-md-12">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>اسم المادة</th>
                              
                              <th>الوحدة</th>

                                <th>العدد</th>
                                <!-- <th>السعر</th> -->
                            
                                <th></th>
                            </tr>
        
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control selectpicker" wire:model.lazy="item" data-live-search="true" wire:change="selectitem">
                                        <option value="">يرجى اختيار المادة</option>
                                         @foreach(App\Models\Warehouseproduct::get() as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                         @endforeach
                                    </select>
                                </td>
                              
                                <td>
                            <select class="form-control" wire:model="unit">
                                <option value="">{{App\Models\UnitConv::where("product_id",$productID)->first()->base->name ?? "قطعة"}}</option>

                                @foreach(App\Models\UnitConv::where("product_id",$productID)->get() as $item)
                                    <option value="{{$item->id}}">{{$item->unit->name}} ({{$item->factor}})</option>
                                @endforeach
                            </select>
                        </td>
                                <td>
                                    <input type="number" class="form-control" wire:model="qtyInput">
                                    @if($unit)
                             {{App\Models\UnitConv::where("id",$unit)->first()->base->name ?? ""}} : {{(App\Models\UnitConv::where("id",$unit)->first()->factor ?? 1) * ($qtyInput == ""? 1 : $qtyInput)}}
                            @endif
                            </td>
                                <!-- <td>@convert($amount)</td> -->
                                
                                <td>
                                    <a href="#addPlus" wire:click="addItem()" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                </td>
                            </tr>
                            @foreach($items as $item)
                            <tr>
        
                            
                            <td>{{$item['productname']}}</td>
                        
                         <td>

{{$item['qtyinput']}}

{{App\Models\UnitConv::where("id",$item['unit'])->first()->unit->name ?? "قطعة"}}

</td>
                         </td>
                            <td>{{$item['qty']}}</td>
                            <!-- <td>
                                @convert($item['total'])
                            </td> -->
                          
                            <td>
                                <a href="#delete" class="btn btn-danger" wire:click="deleteItem({{$loop->index}})"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- <div class="col-12" >
                    <h4>اجمالي السعر :  
                        @convert($totalmenu)
                    </h4>
                </div> -->


              


        </div>
        </div>




        

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.warehouseexport.read')"
                class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>