<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request, $status = null, ?Reseller $reseller = null)
    {
        $orders = $reseller?->getKey() ? $reseller->orders()->getQuery() : Order::has('reseller')->with('reseller');
        if ($request->ajax()) {
            return Datatables::of($orders->status($status)->latest('id')->with('reseller'))
                ->addIndexColumn()
                    // ->addColumn('empty', function($row){
                    //     return '';
                    // })
                ->addColumn('checkbox', fn($row): string => '<input type="checkbox" class="form-control" name="order_id[]" value="'.$row->id.'" style="min-height: 20px;min-width: 20px;max-height: 20px;max-width: 20px;">')
                ->editColumn('id', fn($row): string => '<a class="px-2 btn btn-light btn-sm text-nowrap" href="'.route('admin.order.show', $row->id).'">'.$row->id.'<i class="ml-1 fa fa-eye"></i></a>')
                ->addColumn('reseller', fn($row): string => '<a href="'.route('admin.resellers.show', $row->reseller->id ?? 0).'">
                            <strong>Name:</strong>'.optional($row->reseller)->name.'
                            <div class="my-1"></div>
                            <strong>Phone:</strong>'.optional($row->reseller)->phone.'
                        </a>')
                ->addColumn('customer', fn($row): string => '<strong>Name:</strong>'.$row->data['customer_name'].'
                            <div class="my-1"></div>
                            <strong>Phone:</strong>'.$row->data['customer_phone'])
                ->addColumn('price', function ($row) {
                    $ret = '
                        <strong style="white-space: nowrap;">Buy:</strong> '.theMoney($row->status == 'PENDING' ? $row->data['price'] : ($row->data['buy_price'] ?? $row->data['price']))."
                        <div class='my-1'></div>";
                    if ($row->status == 'PENDING') {
                        $current_price = $row->current_price();
                        if ($row->data['price'] != $current_price) {
                            $ret .= '<strong style="white-space: nowrap;">Current:</strong> '.theMoney($current_price)."
                                <div class='my-1'></div>";
                        }
                    } elseif ($row->data['price'] != ($row->data['buy_price'] ?? $row->data['price'])) {
                        $ret .= '<del style="white-space: nowrap;"><strong>Order:</strong> '.theMoney($row->data['price'])."</del>
                            <div class='my-1'></div>";
                    }

                    return $ret . ('<strong style="white-space: nowrap;">Sell:</strong> ' . theMoney($row->data['sell']) . "
                            <div class='my-1'></div>");
                })
                ->editColumn('status', function ($row) {
                    $return = '<select data-id="'.$row->id.'" onchange="changeStatus" class="status-column form-control-sm">';
                    foreach (config('order.statuses', []) as $status) {
                        $return .= '<option value="'.$status.'" '.($status == strtoupper($row->status) ? 'selected' : '').'>'.$status.'</option>';
                    }
                    $return .= '</select>';

                    if (isset($row->data['booking_number'])) {
                        $return .= '<div><a target="_blank" href="https://merchant.pathao.com/tracking?consignment_id='.$row->data['booking_number'].'">'.$row->data['booking_number'].'</a></div>';
                    }

                    return $return;
                })
                ->addColumn('ordered_at', fn($row): string => '<span style="white-space: nowrap;">'.$row->created_at->format('d-M-Y').'</span><div class="my-1"></div><span>'.$row->created_at->format('h:i A').'</span>')
                ->addColumn('completed_at', function ($row) {
                    $col = $row->status == 'FAILED' ? 'returned_at' : 'completed_at';

                    return isset($row->data[$col]) ? date('d-M-Y', strtotime((string) $row->data[$col])) : 'N/A';
                })
                ->rawColumns(['checkbox', 'id', 'reseller', 'customer', 'status', 'price', 'ordered_at'])
                ->setRowAttr([
                    'data-entry-id' => fn($row) => $row->id,
                ])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reseller(Request $request, ?Reseller $reseller = null, $status = null)
    {
        if ($reseller?->getKey()) {
            $orders = $reseller->orders()->getQuery();
        } else {
            return false;
        }

        if ($request->ajax()) {
            return Datatables::of($orders->status($status)->latest('id')->with('reseller'))
                ->addIndexColumn()
                ->addColumn('empty', fn($row): string => '')
                ->addColumn('customer', fn($row): string => '<strong>Name:</strong>'.$row->data['customer_name'].'
                            <div class="my-1">
                            <strong>Phone:</strong>'.$row->data['customer_phone'])
                ->addColumn('price', function ($row) {
                    $ret = '
                        <strong style="white-space: nowrap;">Buy:</strong> '.theMoney($row->status == 'PENDING' ? $row->data['price'] : ($row->data['buy_price'] ?? $row->data['price']))."
                        <div class='my-1'></div>";
                    if ($row->status == 'PENDING') {
                        $current_price = $row->current_price();
                        if ($row->data['price'] != $current_price) {
                            $ret .= '<strong style="white-space: nowrap;">Current:</strong> '.theMoney($current_price)."
                                <div class='my-1'></div>";
                        }
                    } elseif ($row->data['price'] != ($row->data['buy_price'] ?? $row->data['price'])) {
                        $ret .= '<del style="white-space: nowrap;"><strong>Order:</strong> '.theMoney($row->data['price'])."</del>
                            <div class='my-1'></div>";
                    }

                    return $ret . ('<strong style="white-space: nowrap;">Sell:</strong> ' . theMoney($row->data['sell']) . "
                            <div class='my-1'></div>");
                })
                ->addColumn('status', function ($row) {
                    $variant = $this->variant($row->status);

                    $return = '<span class="badge badge-square badge-'.$variant.' text-uppercase">'.$row->status.'</span>';

                    if (isset($row->data['booking_number'])) {
                        $return .= '<div><a target="_blank" href="https://merchant.pathao.com/tracking?consignment_id='.$row->data['booking_number'].'">'.$row->data['booking_number'].'</a></div>';
                    }

                    return $return;
                })
                ->addColumn('ordered_at', fn($row): string => '<span style="white-space: nowrap;">'.$row->created_at->format('d-M-Y').'</span><div class="my-1"></div><span>'.$row->created_at->format('h:i A').'</span>')
                ->addColumn('completed_returned_at', function ($row) {
                    $col = $row->status == 'FAILED' ? 'returned_at' : 'completed_at';

                    return isset($row->data[$col]) ? date('d-M-Y', strtotime((string) $row->data[$col])) : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary" href="'.route('reseller.order.show', $row->id).'" noclick="window.open(\''.route('reseller.order.show', $row->id).'\', \'popup\', \'width=`100%`, height=`100%`\')">View</a>';
                    $row->status == 'PENDING' && $btn .= '<a class="btn btn-sm btn-danger" href="'.route('reseller.order.cancel', $row->id).'" onclick="if (confirm(\'Are You Sure?\')){return true;}else{event.stopPropagation(); event.preventDefault(); return false;};">Cancel</a>';

                    return $btn . '</div>';
                })
                ->rawColumns(['customer', 'status', 'price', 'ordered_at', 'action'])
                ->setRowAttr([
                    'data-entry-id' => fn($row) => $row->id,
                ])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): void
    {
        //
    }

    private function variant($status): string
    {
        return match (strtolower((string) $status)) {
            'pending' => 'secondary',
            'processing' => 'warning',
            'invoiced' => 'info',
            'shipping' => 'primary',
            'completed' => 'success',
            'failed' => 'danger',
            default => 'default',
        };
    }
}
