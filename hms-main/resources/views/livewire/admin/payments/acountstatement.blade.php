<div class="row" x-data="{'expanded':false}" wire:poll.8750ms>
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">كشف حساب</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')"
                                class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">الحسابات</li>
                    </ul>

                   

                    <div class="row justify-content-between mt-4 mb-4">
                        
                        @if(config('easy_panel.crud.payments.search'))
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode'))
                                    wire:model.lazy="search" @else wire:model="search" @endif
                                    placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin"></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <br>
                        </div>
                        

                        
                        
                        <div class="col-md-4">
                            <label for="">الفترة</label>
                            <div class="input-group">
                                <input autocomplete="off" onchange="daterangeGo()" type="text" id="reportrange" class="form-control" wire:model.lazy="daterange"
                                    wire:ignore>

                                <div class="input-group-append">
                                    
                                    @if($datefilterON)
                                    <button class="btn btn-danger" wire:click="$set('datefilterON',false)">
                                        الغاء
                                    </button>
                                    @endif

                                </div>
                            </div>

                        </div>
                       

                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                                <tr>
                                    <th>المريض</th>
                                    <th>اجمالي القبض</th>
                                    
                                    <th></th>
                                </tr>
                                @foreach($Grouped as $item)
                                <tr>
                                    <td>{{$item->Patient->name ??""}}</td>
                                    
                                    <td>
                                        {{$item->totalincomeiqd}} دينار
                                        <hr>
                                        {{$item->totalincomeusd}} دولار
                                    </td>

                   
                                    <td>
                                    <a href="@route(getRouteName().'.payments.read')?patient_id={{$item->Patient->id}}&account_type=2&daterange={{$daterange}}&datefilterON=true" class="btn btn-info">عرض السندات</a>
                                    <a href="@route(getRouteName().'.payments.create')?account_id={{$item->Patient->id}}&payment_type=2&account_type=2" class="btn btn-info">سند قبض</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $Grouped->appends(request()->query())->links() }}
            </div>

            

        </div>
    </div>
</div>

<script>
    function daterangeGo() {
        var element = document.getElementById("reportrange")
        console.log(element.value)
        Livewire.emit('searchBydate');
        @this.searchBydate(element.value)
    }
</script>