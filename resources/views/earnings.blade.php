<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0">
            <div class="card-header">
                <strong>Earning Status [{{ $period }}]</strong>
                <div class="badge badge-{{ $howPaid ? 'success' : 'secondary' }} p-2 ml-auto" style="font-size: 100%; vertical-align: middle;">{{ $howPaid ? "Paid $howPaid" : "Unpaid" }}</div>
            </div>
            <div class="card-body p-2">
                <div class="row mr-0 mb-2">
                    @foreach($periods as $period)
                        <div class="col-md-4">
                            <a class="w-100 badge @if(request('period') === $period) badge-success @else badge-primary @endif m-1 p-2" href="{{ route('earnings', ['reseller_id' => request('reseller_id'), 'period' => $period]) }}">{{ $period }}</a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Profit</th>
                                        <th>Loss</th>
                                        <th>Advanced</th>
                                        <th>Receivable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $profit = $loss = $advanced = $receivable = 0 @endphp
                                    @foreach($orders as $order)
                                    @php
                                        $p = $order->status == 'completed' ? $order->data['profit'] : 0;
                                        $l = $order->status == 'completed' ? 0 : ($order->data['packaging'] + $order->data['delivery_charge'] + $order->data['cod_charge'] - $order->data['advanced']);
                                        $r = $order->status == 'completed' ? ($p - $order->data['advanced']) : (-$l - $order->data['advanced']);
                                        $profit += $p;
                                        $advanced += $order->data['advanced'];
                                        $loss += $l;
                                        $receivable += $r;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{route(auth('reseller')->check() ? 'reseller.order.show' : 'admin.order.show',$order->id)}}">{{$order->id}}</a>
                                        </td>
                                        <td>{{ucwords($order->status)}}</td>
                                        <td>{{$order->updated_at->format('d-M-Y')}}</td>
                                        <td>{{$p}}</td>
                                        <td>{{$l}}</td>
                                        <td>{{$order->data['advanced']}}</td>
                                        <td>{{$r}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="3" class="text-center">Total</th>
                                        <th>{{ $profit }}</th>
                                        <th>{{ $loss }}</th>
                                        <th>{{ $advanced }}</th>
                                        <th>{{ $receivable }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        Stay With Us.<br>

                        Thank you for using our application!

                        Thanks,<br>
                        {{ config('app.name') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
