<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">تحديث الفحص</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.labtest.read')" class="text-decoration-none">فحوصات المختبر</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

            
            <div class="row">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label for='inputname' class=' control-label'> {{ __('Name') }}</label>
                        <input type='text' wire:model.lazy='name'
                            class="form-control @error('name') is-invalid @enderror" id='inputname'>
                        @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">التصنيف</label>
                    <select class="form-control" wire:model = "category_id">
                        <option value=""></option>
                        @foreach(App\Models\LabCategory::get() as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class='form-group'>
                        <label for='inputname' class=' control-label'>السعر</label>
                        <input type='number' wire:model.lazy='amount'
                            class="form-control @error('amount') is-invalid @enderror" id='inputname'>
                        @error('amount') <div class='invalid-feedback'>{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <h4>عناصر الفحص

<button wire:click.prevent="addComponet" class="btn btn-info">اضافة عنصر</button>

</h4>
<hr>

<table class="table table-bordered" dir="ltr">
<thead>
    <tr style="text-align:left">
        <th>Test</th>
        <th>Result</th>
        <th>Unit</th>
        <th>Normal Range</th>
        <th>سعر الفحص</th>
        <th></th>
    </tr>

    @foreach($compontes as $item)
    <tr>
        <th> <input type="text" class="form-control" wire:change="changekey('name',$event.target.value,{{$loop->index}})" value="{{$item['name']}}"> </th>
        <th>
            <div class="input-group">

                <select class="form-control" wire:change="changekey('result_type',$event.target.value,{{$loop->index}})">
                    <option @if($item['result_type'] == "value") selected @endif  value="value">Value</option>
                    <option @if($item['result_type'] == "select") selected @endif  value="select">Select</option>
                </select>

                <div class="input-group-append">
                    @if($item['result_type'] == "select")
               
                    <button wire:click.prevent="addopt({{$loop->index}})" class="btn btn-info">Add Option</button>
                    @endif
                </div>

            </div>

            

            @if($item['result_type'] == "select")
               
                <hr>

               @foreach($item['options'] as $opt)
                <div class="input-group mt-3">
                <input value="{{$opt}}" type="text" class="form-control" wire:change="changesub($event.target.value,{{$loop->index}},{{$loop->parent->index}})">
                    <div class="input-group-append">
                    <button wire:click.prevent="deleteopt({{$loop->index}},{{$loop->parent->index}})" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
                @endforeach

            @endif

        </th>
        <th><input value="{{$item['unit']}}" type="text" class="form-control" wire:change="changekey('unit',$event.target.value,{{$loop->index}})"> </th>
        <th><textarea class="form-control" wire:change="changekey('normal_range',$event.target.value,{{$loop->index}})">{{$item['normal_range']}}</textarea></th>

        <th>
                            <input type="text" class="form-control" wire:change="changekey('price',$event.target.value,{{$loop->index}})" value="{{$item['price']}}" >
                        </th>
        <th><button wire:click.prevent="deleteItem({{$loop->index}})" class="btn btn-danger"> <i class="fa fa-trash"></i> </button></th>

    </tr>
    @endforeach
    

</thead>
</table>


        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.labtest.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
