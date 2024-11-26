@extends('layouts.ready')

@section('styles')
<style>
    .base-image-inner img {
        height: 100% !important;
        width: 100% !important;
    }
</style>

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">Product: <strong>{{ $product->name }}</strong>
                <div class="card-header-actions">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="card-header-action btn btn-sm btn-primary text-light">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="product-details-wrapper">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-7">
                            <div class="product-image">
                                <div class="base-image">
                                    <a class="base-image-inner"
                                        href="{{ $product->base_image }}">
                                        <img src="{{ $product->base_image }}"
                                            alt="Base Image">
                                        <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                    </a>
                                    @foreach($product->additional_images as $additional_image)
                                    <a class="base-image-inner"
                                        href="{{ $additional_image->path }}">
                                        <img src="{{ $additional_image->path }}"
                                            alt="Additional Image">
                                        <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                    </a>
                                    @endforeach
                                </div>

                                <div class="additional-image">
                                    <div class="thumb-image slick-slide slick-current slick-active">
                                        <img src="{{ $product->base_image }}"
                                            alt="Base Image">
                                    </div>
                                    @foreach($product->additional_images as $additional_image)
                                    <div class="thumb-image">
                                        <img src="{{ $additional_image->path }}"
                                            alt="Additional Image">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
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
                                            <li><strong class="class-info">wholesale</strong>: <span class="text-danger">{{ theMoney($product->wholesale) }}</span></li>
                                            <li><strong class="text-primary">retail</strong>: <span class="text-danger">{{ theMoney($product->retail) }}</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="pull-left">
                                    <label>Stock:</label>

                                    <span class="in-stock">{!! $product->availability !!}</span>
                                </div>

                                <div class="clearfix"><br></div>
                                <h6>Categories:</h6>
                                <div class="categories">
                                    <ul class="mb-0">
                                        @foreach($product->categories as $category)
                                        <li>{{ $category->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="mt-3">Description</h3>
                            <div class="description">{!! $product->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection