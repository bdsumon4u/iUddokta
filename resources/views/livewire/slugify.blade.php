<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="{{ $src['id'] }}">{{ $src['label'] }}</label><span class="text-danger">*</span>
            <input type="text" name="{{ $src['name'] }}" wire:model.debounce.250ms="title" wire:keyup="slugify" value="{{ old($src['name'], $title) }}" id="{{ $src['id'] }}" class="form-control @error($src['name']) is-invalid @enderror">
            {!! $errors->first($src['name'], '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label for="{{ $emt['id'] }}">{{ $emt['label'] }}</label><span class="text-danger">*</span>
            <input type="text" name="{{ $emt['name'] }}" value="{{ $slug }}" id="{{ $emt['id'] }}" class="form-control @error($emt['name']) is-invalid @enderror">
            {!! $errors->first($emt['name'], '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
</div>