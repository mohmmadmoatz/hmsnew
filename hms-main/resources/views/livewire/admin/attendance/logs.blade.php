<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">الحظور والأنصراف</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">الحظور والأنصراف</li>
                    </ul>

                  
                </div>
                   <div class="row justify-content-between mt-4 mb-4">
                     <div class="col-md-4" wire:ignore>
                            <div class="input-group">
                               <select wire:model="search" class="form-control selectpicker" data-live-search="true">
                                   <option value="">حسب الموظف</option>
                                   @foreach(App\Models\Employee::get() as $item)
                                   <option value="{{$item->userid}}">{{$item->name}}</option>
                                   @endforeach
                               </select>
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select wire:model="optype" class="form-control">
                                    <option value="">نوع العملية</option>
                                    <option value="1">حظور</option>
                                    <option value="2">انصراف</option>
                                </select>
                                 <div class="input-group-append">
                                     <button class="btn btn-default">
                                         <a wire:target="optype" wire:loading.remove><i class="fa fa-search"></i></a>
                                         <a wire:loading wire:target="optype"><i class="fas fa-spinner fa-spin" ></i></a>
                                     </button>
                                 </div>
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" wire:model="date">
                                 <div class="input-group-append">
                                     <button class="btn btn-default">
                                         <a wire:target="date" wire:loading.remove><i class="fa fa-search"></i></a>
                                         <a wire:loading wire:target="date"><i class="fas fa-spinner fa-spin" ></i></a>
                                     </button>
                                 </div>
                             </div>
                        </div>
                   </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>اسم الموظف</td>
                        <td>طريقة التسجيل</td>
                        <td>نوع العملية</td>
                        <td>الوقت والتاريخ</td>
                        
                        
                        <td></td>
                    </tr>

                    @foreach ($data as $item)
                        <tr>
                        <td>{{$item->user->name ??""}}</td>
                        <td>{{$item->state}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->timestamp}}</td>
                        
                        
                        <td></td>
                        </tr>
                    @endforeach
                   
                    </tbody>
                </table>
            </div>

            <div class="m-auto pt-3 pr-3">
                {{ $data->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
