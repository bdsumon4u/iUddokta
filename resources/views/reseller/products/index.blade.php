@extends('reseller.products.layout')

@push('styles')
    <style>
        .product-item .card-body {
            position: relative;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="shadow-sm card rounded-0">
                <div class="py-2 card-header">All <strong>Products</strong></div>
                <div class="p-2 card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-5 offset-md-7">
                            <form action="" method="get">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" name="s" placeholder="Product Name"
                                            value="{{ request('s') }}" class="px-2 form-control">
                                        <div class="input-group-append"><span class="p-0 input-group-text"><input
                                                    type="submit" value="Search" class="px-1 h-100"></span></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @foreach ($products as $product)
                            <div class="mb-2 col-md-3 col-lg-2 products">
                                <div class="border product-item">
                                    <div class="shadow-sm card rounded-0">
                                        <a href="{{ route('reseller.product.show', $product->slug) }}">
                                            <img class="p-2 card-img-top" src="{{ $product->base_image }}" alt="Base Image">
                                        </a>
                                        <div class="p-2 card-body">
                                            <a
                                                href="{{ route('reseller.product.show', $product->slug) }}">{{ $product->name }}</a>
                                            <div class="my-2 text-center product-action-2 w-100">
                                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-add-to-cart btn-sm">
                                                        Add To Cart
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <strong>Buy: {{ theMoney($product->wholesale) }}</strong>
                                                <strong>Sell: {{ theMoney($product->retail) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#cat-tog').click(function() {
                if ($('.categories').hasClass('d-md-block')) {
                    $('.categories').removeClass('d-md-block').addClass('d-none');
                    $('.products').addClass('col-sm-6');
                } else if ($('.categories').hasClass('d-none')) {
                    $('.categories').removeClass('d-none').addClass('d-md-block');
                    $('.products').removeClass('col-sm-6');
                }
            });
        });
    </script>
@endpush
