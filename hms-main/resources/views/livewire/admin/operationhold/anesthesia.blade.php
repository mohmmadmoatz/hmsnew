<div style="min-width: 220px">
    @foreach($names as $name)
    <span class="badge badge-info mb-1" style="font-size: 90%">
        {{ $name }}
        <a href="#remove" wire:click.prevent="remove({{ $loop->index }})" class="text-white ml-1" title="حذف"><i class="fa fa-times"></i></a>
    </span>
    @endforeach

    <form wire:submit.prevent="add" class="input-group input-group-sm mt-1">
        <input type="text" class="form-control" wire:model.defer="newName" list="anesthesia-names" placeholder="اسم طبيب التخدير">
        <div class="input-group-append">
            <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i></button>
        </div>
    </form>
</div>
