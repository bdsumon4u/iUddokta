<div id="invoice-reseller" class="card rounded-0 shadow-sm">
    <div class="card-header d-flex align-items-center py-2">Invoice&nbsp;<strong>#{{ $order->id }}</strong></div>
    @include('order.invoice.data')
</div>