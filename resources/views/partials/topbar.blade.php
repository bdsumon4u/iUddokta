<div class="site-header__topbar topbar">
    <div class="topbar__container container">
        <div class="topbar__row">
            <div class="topbar__item topbar__item--link">
                <img style="height: 35px;" class="img-responsive " src="https://www.himelshop.com/front_asset/call-now.gif" alt="Call 7colors" title="7colors">&nbsp;
                <a style="font-family: monospace; font-size: 20px;" class="topbar-link" href="tel:{{ $contact->phone ?? '' }}">{{ $contact->phone ?? '' }}</a>
            </div>
            <div class="topbar__spring"></div>
            <div class="topbar__item topbar__item--link">
                <a href="tel:{{$contact->phone ?? ''}}" target="_blank" class="text-white border" style="height: 25px; width: 25px; display: grid; place-content: center;">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
            <div class="topbar__item topbar__item--link">
                <a href="mailto:{{$company->email ?? ''}}" target="_blank" class="text-white border" style="height: 25px; width: 25px; display: grid; place-content: center;">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
            @foreach($social ?? [] as $item => $data)
                @if($data->display ?? false)
                <div class="topbar__item topbar__item--link">
                    <a href="{{ url($data->link ?? '#') }}" target="_blank" class="text-white border" style="height: 25px; width: 25px; display: grid; place-content: center;">
                        @switch($item)
                            @case('facebook')
                            <i class="fab fa-facebook-f"></i>
                            @break
                            @case('twitter')
                            <i class="fab fa-twitter"></i>
                            @break
                            @case('instagram')
                            <i class="fab fa-instagram"></i>
                            @break
                            @case('youtube')
                            <i class="fab fa-youtube"></i>
                            @break
                        @endswitch
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>