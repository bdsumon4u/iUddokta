<footer class="footer">
    <div class="container">
        <div class="footer-top p-tb-50 clearfix">
            <div class="row">
                <div class="col-md-4">
                    <a href="https://fleetcart.envaysoft.com/en" class="footer-logo">
                        <img src="{{ asset($logo->footer ?? $logo->color) ?? '' }}"
                            class="img-responsive" alt="footer-logo">
                    </a>

                    <div class="clearfix"></div>

                    <p class="footer-brief"></p>

                    <div class="contact">
                        <ul class="list-inline">
                            <li>
                                <i class="fa fa-phone-square" aria-hidden="true"></i>
                                <span class="contact-info">{{ $contact->phone ?? '' }}</span>
                            </li>

                            <li>
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <span class="contact-info">{{ $company->email ?? '' }}</span>
                            </li>

                            <li>
                                <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                <span class="contact-info">{{ $company->address ?? '' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4>My Account</h4>
                                </div>

                                <ul class="list-inline">
                                    <li><a href="{{ route('reseller.home') }}">Dashboard</a>
                                    </li>
                                    <li><a href="{{ route('reseller.order.index') }}">My
                                            Orders</a></li>
                                    <li><a href="{{ route('reseller.profile.show', auth('reseller')->user()->id) }}">My
                                            Profile</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4>{{ $footer_menu->title ?? '' }}</h4>
                                </div>

                                <ul class="list-inline">
                                    @foreach(menuItems($footer_menu->id ?? null) as $item)
                                    <li><a href="{{ url($item->url) }}"
                                            target="_self">{{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-middle p-tb-30 clearfix">
            <ul class="social-links list-inline">
                <li class="d-inline-block"><a href="mailto:{{ $company->email }}"><i class="fa fa-envelope"></i></a></li>
                <li class="d-inline-block"><a href="tel:{{ $contact->phone }}"><i class="fa fa-phone"></i></a></li>
                @foreach($social ?? [] as $name => $item)
                    @if($item->display ?? false)
                    <li class="d-inline-block"><a href="{{ url($item->link ?? '') }}"><i class="fa fa-{{ $name }}"></i></a></li>
                    @endif
                @endforeach
            </ul>
            <!-- <ul class="social-links list-inline">
                <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            </ul> -->
        </div>
    </div>

    <div class="footer-bottom p-tb-20 clearfix">
        <div class="container">
            <div class="copyright text-center">
                Copyright © {{ $company->name }} - 2020. Developed By <a href="https://cyber32.com">Cyber32</a>.
            </div>
        </div>
    </div>
</footer>