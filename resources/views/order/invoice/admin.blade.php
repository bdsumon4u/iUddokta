<div id="invoice-admin" class="card rounded-0 shadow-sm" style="margin-bottom: 0.5in;">
    <div class="card-header d-flex align-items-center py-2">Invoice&nbsp;<strong>#{{ $order->id }}</strong>
        <a class="btn btn-sm btn-print btn-info ml-auto mr-1 d-print-none" href="">Print</a>
    </div>
    @include('order.invoice.data', ['qrcode' => ''])
</div>