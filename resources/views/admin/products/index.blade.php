@extends('layouts.ready')

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
                                            value="{{ request('s') }}" class="form-control">
                                        <div class="input-group-append"><span class="p-0 input-group-text"><input
                                                    type="submit" value="Search" class="h-100"></span></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @foreach ($products as $product)
                            <div class="col-md-3 col-lg-2 products">
                                <div class="product-item">
                                    <div
                                        class="shadow-sm card rounded-0 @unless ($product->is_active) border border-danger @endunless">
                                        <a href="{{ route('admin.products.show', $product->id) }}">
                                            <img class="p-2 card-img-top" src="{{ $product->base_image }}" alt="Base Image">
                                            <div class="p-2 card-body">
                                                <div class="card-title-text">{{ $product->name }}</div>
                                            </div>
                                        </a>
                                        <div class="p-2 card-footer">
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
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
