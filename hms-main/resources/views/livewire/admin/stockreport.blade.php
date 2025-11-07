<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">كشف قسم او حساب</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">المخازن</li>
                    </ul>

                  
                </div>
            </div>

          <div class="card-body">
            <div class="row">

            <div class="col-md-12">
            <label for="">الفترة</label>
                            <div class="input-group">
                                <input wire:ignore autocomplete="off" type="text" id="reportrange"  onchange="daterangeGo()" class="form-control" wire:model.lazy="daterange">
                                <div class="input-group-append">
                                  
                                    @if($datefilterON)
                                    <button class="btn btn-danger" wire:click="$set('datefilterON',false)">
                                        الغاء
                                    </button>
                                    @endif

                                </div>
                                
                            </div>
            </div>

                <div class="col-md-6" wire:ignore>
                    <label for='inputname' class=' control-label'> {{ __('القسم') }}</label>
                        <select data-live-search="true" class="selectpicker form-control @error('name') is-invalid @enderror" id='name'  wire:model.lazy='name'>
                                <option value=""></option>
                                @foreach(App\Models\Stocksup::where("type","قسم")->get() as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>

                                @endforeach
                            </select>
                </div>

                <div class="col-md-6" wire:ignore>
                    <label for='inputname' class=' control-label'> {{ __('الحساب') }}</label>
                        <select data-live-search="true" class="selectpicker form-control @error('name') is-invalid @enderror" id='name'  wire:model.lazy='company'>
                                <option value=""></option>
                                @foreach(App\Models\Stocksup::where("type","شركة")->get() as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>

                                @endforeach
                            </select>
                </div>

                <div class="col-md-6 mt-4">
                    <a  class="btn btn-info btn-block" href="@route('stockreport')?cat={{$name}}&dates={{$daterange}}" target="_blank" rel="noopener noreferrer">كشف</a>
                </div>

                <div class="col-md-6 mt-4">
                    <a  class="btn btn-info btn-block" href="@route('companyreport')?cat={{$company}}&dates={{$daterange}}" target="_blank" rel="noopener noreferrer">كشف</a>
                </div>

            </div>
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