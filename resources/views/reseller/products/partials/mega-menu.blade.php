<div class="megamenu-wrapper hidden-xs">
    <div class="container">
        <nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
                <!-- <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" target="_self">
                        Home Pages
                    </a>

                    <ul class="dropdown-menu multi-level">
                        <li class="">
                            <a href="https://fleetcart.envaysoft.com/en/change-layout/default" class="" target="_self">
                                Home Page 1
                            </a>

                        </li>
                        <li class="">
                            <a href="https://fleetcart.envaysoft.com/en/change-layout/slider_with_banners" class=""
                                target="_self">
                                Home Page 2
                            </a>

                        </li>
                    </ul>
                </li> -->
                @foreach(menuItems($header_menu->id ?? null) as $item)
                <li class=" ">
                    <a href="{{ url($item->url) }}" class="" target="_self">
                        {{ $item->title }}
                    </a>

                    <ul class="dropdown-menu multi-level">
                    </ul>
                </li>
                @endforeach
                <!-- <li class=" ">
                    <a href="https://fleetcart.envaysoft.com/en/about-us" class="" target="_self">
                        About US
                    </a>

                    <ul class="dropdown-menu multi-level">
                    </ul>
                </li>
                <li class=" ">
                    <a href="https://fleetcart.envaysoft.com/en/contact" class="" target="_self">
                        Contact US
                    </a>

                    <ul class="dropdown-menu multi-level">
                    </ul>
                </li> -->
            </ul>
        </nav>
    </div>
</div>