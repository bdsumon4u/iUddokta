<div class="table-responsive">
    <table class="table">
        <tbody>
            @foreach ($cart as $cartItem)
                @php $product = $cartItem['attributes']['product'] @endphp
                <tr class="cart-item">
                    <td>
                        <img src="{{ $product->base_image }}" alt="Base Image" width="150" height="150">
                    </td>

                    <td>
                        <h5>
                            <a href="{{ route('reseller.product.show', $product['slug']) }}">{{ $cartItem['name'] }}</a>
                        </h5>
                    </td>

                    <td>
                        <div class="pull-left" style="margin: 10px;">
                            <label><strong class="badge badge-secondary">Price:</strong></label>
                            <ul class="list-unstyled">
                                <li><strong class="text-info" style="width: 110px; float: left;">WHOLESALE</strong> :&nbsp;<span>{{ theMoney($cartItem['price']) }}</span></li>
                                <li><strong class="text-primary" style="width: 110px; float: left;">RETAIL</strong> :&nbsp;<span>{{ theMoney($product['retail']) }}</span></li>
                            </ul>
                        </div>
                        <div class="pull-left" style="margin: 10px;">
                            <label for=""><strong class="badge badge-secondary">Quantity:</strong></label>
                            <br>
                            <div class="quantity pull-left clearfix">
                                <div class="input-group-quantity pull-left clearfix">
                                    <button type="button" class="btn btn-number btn-minus btn-sm btn-primary" datatype="minus" wire:click="decrement({{ $cartItem['id'] }})" {{ $cartItem['quantity'] === 1 ? 'disabled' : '' }}> &#8211; </button>
                                    <input type="text" name="qty" value="{{ $cartItem['quantity'] }}" class="input-number input-quantity" min="1" max="{{ $product->stock }}" size="5">
                                    <button type="button" class="btn btn-number btn-plus btn-sm btn-primary" datatype="plus" wire:click="increment({{ $cartItem['id'] }})" {{ !is_null($product->stock) && $cartItem['quantity'] >= $product->stock ? 'disabled' : '' }}> + </button>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td></td>
                    <td></td>

                    <td width="1">
                        <form method="POST" action="{{ route('cart.remove', $cartItem['id']) }}" onsubmit="return confirm('Are Your Sure To Remove It?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Remove">
                                &times;
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>