<label for='inputpat_id' class='control-label'> {{ __('Pat_id') }} 

<a wire:loading wire:target="{{$model}}"><i class="fas fa-spinner fa-spin" ></i></a>
</label>

<div  class="dropdown show">

<input autocomplete="off" x-on:change.debounce = "show=true" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" type='text' wire:model.debounce='{{$model}}'  class="form-control @error($model) is-invalid @enderror" id='inputpat_id'>

@if($$model && !$selected)
<div style="display:block" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
@foreach(App\Models\Patient::where("name","like",$$model . "%")->limit(10)->get() as $item)
<a @click="show=false" class="dropdown-item" href="#{{$item->id}}" wire:click="selectpat({{$item->id}})">{{$item->name}}</a>
@endforeach
</div>
@endif
</div>
