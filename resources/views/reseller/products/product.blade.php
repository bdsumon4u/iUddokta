@extends('reseller.products.layout')

@section('title')
    <title>{{ $company->name }} - {{ $product->name }}</title>
@endsection

@push('styles')
    <style>
        .price-box {
            min-width: 240px;
            width: max-content;
            padding-right: 10px;
            display: flex;
            align-items: center;
            border: 3px double #ddd;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .price-box .left {
            padding: 10px;
            border-right: 3px double #ddd;
            margin-right: 10px;
            width: 60px;
        }

        .price-box .right strong {
            width: 90px;
            display: inline-block;
            font-variant: small-caps;
            font-size: 16px;
        }

        .price-box .right strong+span {
            margin-left: 2px;
        }

        .slick-initialized .slick-list {
            overflow: hidden;
        }

        .slick-initialized .slick-slide {
            display: block;
            float: left;
        }
    </style>
@endpush

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-5 col-xs-7">
                <div class="product-image">
                    <div class="base-image">
                        <a class="base-image-inner" href="{{ $product->base_image }}">
                            <img width="320" src="{{ $product->base_image }}" alt="Base Image">
                            <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                        </a>
                        @foreach ($product->additional_images as $additional_image)
                            <a class="base-image-inner" href="{{ $additional_image->path }}">
                                <img src="{{ $additional_image->path }}" alt="Additional Image">
                                <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                            </a>
                        @endforeach
                    </div>

                    <div class="additional-image">
                        <div class="thumb-image slick-slide slick-current slick-active">
                            <img src="{{ $product->base_image }}" alt="Base Image">
                        </div>
                        @foreach ($product->additional_images as $additional_image)
                            <div class="thumb-image">
                                <img src="{{ $additional_image->path }}" alt="Additional Image">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-7 col-xs-12">
                <div class="product-details">
                    <h1 class="product-name">{{ $product->name }}</h1>

                    <div class="code">
                        <label>CODE: </label>
                        <span class="text-uppercase">{{ $product->code }}</span>
                    </div>


                    <div class="clearfix"></div>

                    <div class="price-box">
                        <div class="left">
                            <strong>Price</strong>
                        </div>
                        <div class="right">
                            <ul class="list-unstyled">
                                <li><strong class="class-info">wholesale</strong>: <span
                                        class="text-danger">{{ theMoney($product->wholesale) }}</span></li>
                                <li><strong class="text-primary">retail</strong>: <span
                                        class="text-danger">{{ theMoney($product->retail) }}</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="pull-left">
                        <label>Stock:</label>

                        <span class="in-stock">{!! $product->availability !!}</span>
                    </div>

                    <div class="clearfix"><br></div>

                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="clearfix d-flex flex-column"
                        style="width: 240px;">
                        @csrf
                        <div class="quantity pull-left clearfix mb-2">
                            <label class="pull-left" for="qty">Quantity</label>

                            <div class="input-group-quantity pull-left clearfix">
                                <input type="text" name="qty" value="1"
                                    class="input-number input-quantity pull-left ml-2" id="qty" min="1"
                                    max="{{ $product->stock }}" size="5">

                                {{-- <span class="pull-left btn-wrapper">
                                    <button type="button" class="btn btn-number btn-plus" data-type="plus"> +
                                    </button>
                                    <button type="button" class="btn btn-number btn-minus" data-type="minus"
                                        disabled=""> – </button>
                                </span> --}}
                            </div>
                        </div>

                        <button type="submit" class="add-to-cart btn btn-primary pull-left" data-loading="">
                            Add to cart
                        </button>
                    </form>
                    <div class="clearfix"></div>
                    <h4 style="margin-top: 2.5rem;">Categories</h4>
                    <ul style="margin-top: .55rem; margin-left: 1.5rem;">
                        @foreach ($product->categories as $category)
                            <li><a
                                    href="{{ route('reseller.product.by-category', [$category->slug, $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div id="description" class="description my-5 border bg-white p-5">
            <h4><span class="border-bottom">Description</span></h4>
            {!! $product->description !!}
        </div>
    </div>
@endsection
