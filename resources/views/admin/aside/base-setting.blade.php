<div class="p-2">
    <form id="base-setting" action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="contact-phone">Contact Phone</label>
            <input type="text" name="contact[phone]" id="contact-phone" value="{{ old('contact.phone', $contact->phone ?? '') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="color-logo">Header Logo</label>
            <input type="file" name="logo[color]" id="color-logo" class="mb-1 @if($logo->color ?? '') d-none @endif">
            <img src="{{ asset($logo->color ?? '') ?? '' }}" alt="Color Logo" class="img-responsive" style="@unless($logo->color ?? '') display:none; @endunless width:215px;height:46px;">
        </div>
        <div class="form-group">
            <label for="white-logo">Dashboard Logo</label>
            <input type="file" name="logo[white]" id="white-logo" class="mb-1 @if($logo->white ?? '') d-none @endif">
            <img src="{{ asset($logo->white ?? '') ?? '' }}" alt="White Logo" class="img-responsive" style="@unless($logo->white ?? '') display:none; @endunless width:215px;height:46px;">
        </div>
        <div class="form-group">
            <label for="footer-logo">Footer Logo</label>
            <input type="file" name="logo[footer]" id="footer-logo" class="mb-1 @if($logo->footer ?? '') d-none @endif">
            <img src="{{ asset($logo->footer ?? '') ?? '' }}" alt="Footer Logo" class="img-responsive" style="@unless($logo->footer ?? '') display:none; @endunless width:215px;height:46px;">
        </div>
        <div class="form-group">
            <label for="favicon-logo">Favicon</label>
            <input type="file" name="logo[favicon]" id="favicon-logo" class="mb-1 @if($logo->favicon ?? '') d-none @endif">
            <img src="{{ asset($logo->favicon ?? '') ?? '' }}" alt="Favicon" class="img-responsive" style="@unless($logo->favicon ?? '') display:none; @endunless width:36px;height:36px;">
        </div>
        <button type="submit" class="btn btn-sm btn-success">Save</button>
    </form>
</div>