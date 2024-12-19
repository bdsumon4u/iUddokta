@extends('layouts.ready')

@section('styles')
<style>
    .product-item .card-body {
        position: relative;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="shadow-sm card rounded-0">
            <div class="py-2 card-header">Trashed <strong>Products</strong></div>
            <div class="p-2 card-body">
                <div class="row justify-content-between">
                    <div class="col-md-5 offset-md-7">
                        <form action="" method="get">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" name="s" placeholder="Product Name" value="{{ request('s') }}" class="form-control">
                                    <div class="input-group-append"><span class="p-0 input-group-text"><input type="submit" value="Search" class="h-100"></span></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @foreach($products as $product)
                    <div class="col-md-4 col-lg-3 products">
                        <div class="product-item">
                            <div class="shadow-sm card rounded-0">
                                <img class="p-2 card-img-top" src="{{ $product->base_image }}" alt="Base Image">
                                <div class="p-2 card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('admin.products.restore', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                        </form>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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

@section('scripts')
<script>
    $(document).ready(function(){
        $('#cat-tog').click(function() {
            if($('.categories').hasClass('d-md-block')) {
                $('.categories').removeClass('d-md-block').addClass('d-none');
                $('.products').addClass('col-sm-6');
            }
            else if($('.categories').hasClass('d-none')) {
                $('.categories').removeClass('d-none').addClass('d-md-block');
                $('.products').removeClass('col-sm-6');
            }
        });
    });
</script>
@endsection
