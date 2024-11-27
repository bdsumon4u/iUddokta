<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status, ?Reseller $reseller = null)
    {
        if ($reseller?->getKey()) {
            $orders = $reseller->transactions()->getQuery();
        } else {
            $orders = Transaction::query();
        }
        if ($request->ajax()) {
            return Datatables::of($orders->status($status)->latest()->with('reseller'))
                ->addIndexColumn()
                ->addColumn('empty', function ($row) {
                    return '';
                })
                ->addColumn('id', function ($row) {
                    return '<a href="'.route(auth('reseller')->check() ? 'reseller.transactions.show' : 'admin.transactions.show', $row->id ?? 0).'">'.$row->id.'</a>';
                })
                ->addColumn('reseller', function ($row) {
                    return '<a href="'.route(auth('reseller')->check() ? 'reseller.profile.show' : 'admin.resellers.show', data_get($row->reseller, 'id', 0)).'">
                            <strong>Name:</strong>'.($row->reseller->name ?? '').'
                            <br>
                            <strong>Phone:</strong>'.($row->reseller->phone ?? '').'
                        </a>';
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('F j, Y');
                })
                ->addColumn('way', function ($row) {
                    $ret = '<strong>Method:</strong> '.$row->method;
                    if ($row->method == 'Bank') {
                        $ret .= ' [ <strong>'.$row->bank_name.'</strong> ] <br>
                        <strong>Name:</strong> '.$row->account_name.
                        '<br>
                        <strong>Branch:</strong> '.$row->branch.
                        '<br>
                        <strong>Routing No:</strong> '.$row->routing_no;
                    }

                    return $ret;
                })
                ->addColumn('pay', function ($row) {
                    return '<a class="btn btn-sm btn-block btn-primary" href="'.route('admin.transactions.pay-to-reseller', [data_get($row->reseller, 'id', 0),
                        'transaction_id' => $row->id,
                        'amount' => $row->amount,
                        'method' => $row->method,
                        'bank_name' => $row->bank_name,
                        'account_name' => $row->account_name,
                        'branch' => $row->branch,
                        'routing_no' => $row->routing_no,
                        'account_type' => $row->account_type,
                        'account_number' => $row->account_number,
                    ]).'">Pay</a>';
                })
                ->rawColumns(['id', 'reseller', 'way', 'pay'])
                ->setRowAttr([
                    'data-entry-id' => function ($row) {
                        return $row->id;
                    },
                ])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
