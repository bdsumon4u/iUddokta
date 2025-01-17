@extends('reseller.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="shadow-sm card rounded-0">
            <div class="card-header">
                <strong>My Shops</strong>
                <div class="card-header-actions"><a href="{{ route('reseller.shops.create') }}" class="card-header-action btn btn-sm btn-primary text-light">Add New</a></div>
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    @foreach($shops as $shop)
                    <div class="col-md-6">
                        <div class="shadow-sm card rounded-0">
                            <div class="py-2 card-header">{{ $shop->name }}
                                <div class="card-header-actions"><a href="{{ route('reseller.shops.edit', $shop->id) }}" class="card-header-action btn btn-sm btn-primary text-light">Edit</a></div>
                            </div>
                            <div class="p-2 card-body">
                                <img src="{{ asset('storage/'.$shop->logo) }}" alt="" class="mx-auto img-responsive thumbnail d-block">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $shop->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $shop->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $shop->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Website:</th>
                                        <td><a>{{ $shop->website }}</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection