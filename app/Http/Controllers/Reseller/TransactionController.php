<?php

namespace App\Http\Controllers\Reseller;

use App\Events\TransactionRequestRecieved;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reseller = auth('reseller')->user();
        $transactions = $reseller->transactions;

        return view('reseller.transactions.index', compact('reseller', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function request()
    {
        $reseller = auth('reseller')->user();
        return view('reseller.transactions.request', compact('reseller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reseller = auth('reseller')->user();
        $data = $request->validate([
            'amount' => 'required|integer',
            'method' => 'required',
            'bank_name' => 'nullable',
            'account_name' => 'nullable',
            'branch' => 'nullable',
            'routing_no' => 'nullable',
            'account_type' => 'required',
            'account_number' => 'nullable',
        ]);
        $data['reseller_id'] = $reseller->id;

        if($transaction = Transaction::create($data)) {
            event(new TransactionRequestRecieved($transaction));
        }
        return redirect()->back()->with('success', 'Money Request Sent.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {

        $fOfCurrMonth = $transaction->created_at->firstOfMonth();
        $mOfCurrMonth = $fOfCurrMonth->copy()->addDays(14);

        $fOfPrevMonth = $transaction->created_at->subMonth()->firstOfMonth();
        $mOfPrevMonth = $fOfPrevMonth->copy()->addDays(14);
        $lOfPrevMonth = $transaction->created_at->subMonth()->lastOfMonth();

        $this->timezone = $transaction->created_at->day >= 1 && $transaction->created_at->day <= 15 ? [
            $mOfPrevMonth->addDay()->toDateTimeString(), $lOfPrevMonth->endOfDay()->toDateTimeString(),
        ] : [
            $fOfCurrMonth->toDateTimeString(), $mOfCurrMonth->endOfDay()->toDateTimeString(),
        ];

        $query = $transaction->reseller->orders()->whereIn('status', ['completed', 'returned']);
        $orders = $query->where(function ($query) {
            return $query->whereBetween('data->completed_at', $this->timezone)
                ->orWhereBetween('data->returned_at', $this->timezone);
        })->get();

        return view('reseller.transactions.show', [
            'data' => $transaction->toArray(),
            'timezone' => $this->timezone,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
