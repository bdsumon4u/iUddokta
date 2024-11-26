@section('styles')
<style>
    .address {
        margin-top: .25rem;
        margin-bottom: .25rem;
        white-space: break-spaces;
    }
    @if(auth('reseller')->check())
        #invoice-admin {
            display: none;
        }
    @else
        #invoice-reseller {
            display: none;
        }
    @endif
    #ui-view div {
        font-size: 16px;
    }
    @media print {
        @page {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
        #invoice-wrapper {
            margin-top: 0 !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        #invoice-reseller {
            display: flex;
        }
        @if(! auth('reseller')->check())
        #invoice-admin {
            display: flex;
        }
        @endif
        #ui-view > .card {
            box-shadow: none !important;
            /* border: 0 !important; */
            /* page-break-before: none; */
        }
        tr.head-row {
            background-color: red !important;
            -webkit-print-color-adjust: exact; 
        }
    }
    .subtotal {
        border-top: 3px solid #555;
        border-bottom: 3px solid #555;
    }
    .payable {
        border-top: 3px solid #ccc;
    }
    .qr-code > * {
        height: 160px;
        width: 160px;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div id="invoice-wrapper" class="col-md-8 my-5">
        <div id="ui-view">
            @php $shop = $order->shop @endphp
            @include('order.invoice.admin')
            @include('order.invoice.reseller')
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.btn-print').click(function (e) {
            e.preventDefault();
            javascript:window.print();
        });
    });
</script>
@endsection