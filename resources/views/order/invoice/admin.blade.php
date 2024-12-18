<div id="invoice-admin" class="shadow-sm card rounded-0" style="margin-bottom: 0.5in;">
    <div class="py-2 card-header d-flex align-items-center">Invoice&nbsp;<strong>#{{ $order->id }}</strong>
        <a class="ml-auto mr-1 btn btn-sm btn-print btn-info d-print-none" href="">Print</a>
    </div>
    @include('order.invoice.data', ['qrcode' => 'https://barcode.tec-it.com/barcode.ashx?data='.$order->barcode.'&code=Code128&translate-esc=true'])
</div>