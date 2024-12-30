<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{route(auth('reseller')->check() ? 'reseller.order.show' : 'admin.order.show',$order->id)}}">{{$order->id}}</a>
                </td>
                <td>{{ucwords($order->status)}}</td>
                <td>{{$order->created_at->format('d-M-Y')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>