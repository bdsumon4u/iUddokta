<section class="col-md-12">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="">City</label><span>*</span>
            <select name="city_id" class="form-control" wire:model.live="city_id">
                <option value="" selected>Select City</option>
                @foreach ($this->getCityList() as $city)
                    <option value="{{ $city->city_id }}">
                        {{ $city->city_name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('city_id', '<span class="error-message">:message</span>') !!}
        </div>
        <div class="form-group col-md-6">
            <label for="">Area</label><span>*</span>
            <div wire:loading.class="d-flex" wire:target="city_id" class="d-none h-100 align-items-center">
                Loading Area...
            </div>
            <input type="hidden" name="area_id" value="{{ old('area_id', $area_id ?? '') }}">
            <select wire:loading.remove wire:target="city_id" class="form-control" wire:model.live="area_id">
                <option value="" selected>Select Area</option>
                @foreach ($this->getAreaList() as $area)
                    <option value="{{ $area->zone_id }}">
                        {{ $area->zone_name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('area_id', '<span class="error-message">:message</span>') !!}
        </div>
    </div>
</section>