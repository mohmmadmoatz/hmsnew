<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('مادة') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.warehouseitem.read')" class="text-decoration-none">تحديث مادة</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <!-- Name Input -->
            <div class='form-group'>
                <label for='inputname' class='col-sm-2 control-label'> {{ __('Name') }}</label>
                <input type='text' wire:model.lazy='name' class="form-control @error('name') is-invalid @enderror" id='inputname'>
                @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <div class='form-group'>
                <label for='inputname' class='col-sm-2 control-label'>تاريخ الانتهاء</label>
                <input type='date' wire:model.lazy='expire' class="form-control @error('name') is-invalid @enderror" id='inputname'>
                @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="">الفئة</label>
                <select class="form-control" wire:model="cat">
                                <option value="">-- بدون --</option>
                                @foreach(App\Models\Stockcat::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
            </div>
            
      
            <hr>
            

            <h4>الوحدات</h4>
            <label for="">الوحدة الأساسية :  مثال (قطعة)</label>
            <select wire:model="baseunit" name="" id="" class="form-control">
                <option value="">اختر الوحدة الأساسية</option>
                @foreach (App\Models\Unit::get() as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>

            <hr>
          <div class="row">
            <div class="col-md-6">
            <label for="">اضافة وحدة</label>
            <select name="" id="" class="form-control" wire:model="unit_id">
                <option value="">اختيار الوحدة</option>
                @foreach (App\Models\Unit::where("id","!=",$baseunit)->get() as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
            </div>
            <div class="col-md-6">
                <label for="">

                    عدد ال ({{ App\Models\Unit::find($baseunit)->name ?? ""  }}) 

                    في ({{ App\Models\Unit::find($unit_id)->name  ??"" }})

                </label>
                <input type="text" class="form-control" wire:model.lazy="unitfactor">
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-12">
                <button class="btn btn-info btn-block" wire:click.prevent="addUnit">حفظ الوحدة</button>
            </div>

            

            <div class="col-md-12">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>الوحدة</th>
                            <th>الكمية</th>
                         
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\UnitConv::where("product_id",$warehouseitem->id)->get() as $item)
                        <tr>
                            <td>{{$item->unit->name}}</td>
                            <td>{{$item->factor}}</td>
                            <td><button class="btn btn-danger" wire:click.prevent="deleteUnitConv({{$item->id}})">حذف</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            </div>
           
          

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.warehouseitem.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
