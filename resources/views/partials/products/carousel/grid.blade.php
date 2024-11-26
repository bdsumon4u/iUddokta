<div class="block block-products-carousel" data-layout="grid-{{ $cols ?? 5 }}">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title">{{ $title }}</h3>
            <div class="block-header__divider"></div>
            <div class="block-header__arrows-list">
                <button class="block-header__arrow block-header__arrow--left" type="button">
                    <svg width="7px" height="11px">
                        <use xlink:href="{{ asset('strokya/images/sprite.svg#arrow-rounded-left-7x11') }}"></use>
                    </svg>
                </button>
                <button class="block-header__arrow block-header__arrow--right" type="button">
                    <svg width="7px" height="11px">
                        <use xlink:href="{{ asset('strokya/images/sprite.svg#arrow-rounded-right-7x11') }}"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="block-products-carousel__slider">
            <div class="block-products-carousel__preloader"></div>
            <div class="owl-carousel">
                @foreach($products->chunk($rows ?? 2) as $products)
                <div class="block-products-carousel__column">
                    @foreach($products as $product)
                    <div class="block-products-carousel__cell">
                        <div class="product-card" data-id="{{ $product->id }}" data-max="{{ $product->should_track ? $product->stock_count : -1 }}">
                            @exp($in_stock = !$product->should_track || $product->stock_count > 0)
                            <div class="product-card__badges-list">
                                @if(! $in_stock)
                                <div class="product-card__badge product-card__badge--sale">Sold</div>
                                @endif
                            </div>
                            <div class="product-card__image">
                                <a href="{{ route('products.show', $product) }}">
                                    <img src="{{ asset($product->base_image->src) }}" alt="">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </div>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__prices {{$product->selling_price == $product->price ? '' : 'has-special'}}">
                                    @if($product->selling_price == $product->price)
                                    {!!  theMoney($product->price)  !!}
                                    @else
                                    <span class="product-card__new-price">{!!  theMoney($product->selling_price)  !!}</span>
                                    <span class="product-card__old-price">{!!  theMoney($product->price)  !!}</span>
                                    @endif
                                </div>
                                <div class="product-card__buttons">
                                    @exp($available = !$product->should_track || $product->stock_count > 0)
                                    <button class="btn btn-primary product-card__addtocart" type="button" {{ $available ? '' : 'disabled' }}>Add To Cart</button>
                                    <button class="btn btn-primary product-card__ordernow" type="button" {{ $available ? '' : 'disabled' }}>Order Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>