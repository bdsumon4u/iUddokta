<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{route(auth('reseller')->check() ? 'reseller.order.show' : 'admin.order.show',$order->id)}}">{{$order->id}}</a>
                </td>
                <td>{{ucwords($order->status)}}</td>
                <td>{{date('d-M-Y',strtotime($order->data[$order->status . '_at']))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>