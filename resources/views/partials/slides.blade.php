<div class="block-slideshow block-slideshow--layout--with-departments block">
    <div id="slideshow-container" class="container">
        <div class="row">
            <div class="col-12 -col-lg-9 -offset-lg-3">
                <div class="block-slideshow__body">
                    <div class="owl-carousel">
                        @foreach($slides as $slide)
                        <a class="block-slideshow__slide" href="{{ $slide->btn_href ?? '#' }}">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                style="background-image: url({{ asset($slide->desktop_src) }}); background-position: center;"></div>
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                style="background-image: url({{ asset($slide->mobile_src) }}); background-position: center;"></div>
                            <div class="block-slideshow__slide-content">
                                <div class="block-slideshow__slide-title">{!! $slide->title !!}</div>
                                <div class="block-slideshow__slide-text">{!! $slide->text !!}</div>
                                @if($slide->btn_href && $slide->btn_name)
                                <div class="block-slideshow__slide-button">
                                    <span class="btn btn-primary btn-lg">{{ $slide->btn_name }}</span>
                                </div>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>