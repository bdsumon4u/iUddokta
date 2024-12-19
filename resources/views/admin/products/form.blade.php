<div class="row">
    <div class="col-sm-12">
        <h4><small class="mb-1 border-bottom">General</small></h4>
    </div>
</div>
<div class="form-group">
    <label for="edit-name">Name</label><span class="text-danger">*</span>
    <input type="text" name="name" value="{{ old('name', $product->name) }}" id="edit-name" data-target="#edit-slug" class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="edit-slug">Slug</label><span class="text-danger">*</span>
    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" id="edit-slug" class="form-control @error('slug') is-invalid @enderror">
    @error('slug')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="description">Description</label><span class="text-danger">*</span>
            <textarea editor name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            {!! $errors->first('description', '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label for="categories" class="@error('categories') is-invalid @enderror">Categories</label><span class="text-danger">*</span>
            <x-category-dropdown :categories="$categories" :selected="$product->categories->pluck('id')->toArray()" name="categories[]" placeholder="Select Category" id="categories" multiple="true" />
            {!! $errors->first('categories', '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h4><small class="mb-1 border-bottom">Price</small></h4>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="wholesale">Wholesale Price</label><span class="text-danger">*</span>
            <input type="text" name="wholesale" value="{{ old('wholesale', $product->wholesale) }}" id="wholesale" class="form-control @error('wholesale') is-invalid @enderror">
            {!! $errors->first('wholesale', '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="retail">Retail Price</label><span class="text-danger">*</span>
            <input type="text" name="retail" id="retail" value="{{ old('retail', $product->retail) }}" class="form-control @error('retail') is-invalid @enderror">
            {!! $errors->first('retail', '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h4><small class="mb-1 border-bottom">Track Inventory</small></h4>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="hidden" name="should_track" value="0">
                <input type="checkbox" name="should_track" value="1" @if(old('should_track', is_numeric($product->stock))) checked @endif id="should-track" class="custom-control-input">
                <label for="should-track" class="custom-control-label @error('stock') is-invalid @enderror">Track</label>
                @error('stock')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group stock-count" @if(!old('should_track', is_numeric($product->stock))) style="display: none;" @endif>
            <label for="stock">Stock Count</label>
            <input type="text" name="stock" value="{{ old('stock', $product->stock) }}" id="stock" class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h4><small class="mb-1 border-bottom">Product Images</small></h4>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <!-- Button to Open the Modal -->
                    <label for="base_image" class="d-block"><strong>Base Image</strong></label>
                    <button type="button" class="btn single btn-primary" data-toggle="modal" data-target="#select-images-modal" style="display: none; height: 150px; width: 150px; background: transparent;">
                        <i class="fa fa-image fa-4x text-primary"></i>
                    </button>
                    
                    <img src="{{ $product->base_image }}" alt="Base Image" id="base_image-preview" class="img-thumbnail img-responsive" style="height: 150px; width: 150px; cursor: pointer;">
                    
                    <input type="hidden" name="base_image" value="{{ old('base_image', optional($product->baseImage())->id ?? 0) }}" class="@error('base_image') is-invalid @enderror" id="base-image" class="form-control">
                    @error('base_image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="additional_images" class="d-block"><strong>Additional Images</strong></label>
                    <button type="button" class="btn multiple btn-primary" data-toggle="modal" data-target="#select-images-modal" style="height: 150px; width: 150px; background: transparent;">
                        <i class="fa fa-image fa-4x text-primary"></i>
                    </button>

                    @foreach($product->additional_images as $additional_image)
                    <div class="previewer">
                        <img src="{{ $additional_image->path }}" alt="Additional Image" id="additional_images-preview-{{ $additional_image->id }}" class="img-thumbnail img-responsive" style="height: 150px; width: 150px;">
                        <i data-remove="{{ $additional_image->id }}" class="fa fa-close"></i>
                    </div>
                    @endforeach
                    <input type="hidden" name="additional_images" value="{{ old('additional_images', implode(',', $product->additional_images->pluck('id')->toArray()) ) }}" class="@error('additional_images') is-invalid @enderror" id="additional-images" class="form-control">

                    @error('additional_images')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @if(old('is_active', is_numeric($product->is_active))) checked @endif id="is-active" class="custom-control-input">
        <label for="is-active" class="custom-control-label @error('is_active') is-invalid @enderror">Is Active</label>
        @error('is_active')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="mb-0 form-group">
    <button type="submit" class="btn btn-success">Submit</button>
</div>