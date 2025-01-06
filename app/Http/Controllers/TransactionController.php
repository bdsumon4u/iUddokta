<?php

namespace App\Http\Controllers;

use App\Events\TransactionCompleted;
use App\Models\Order;
use App\Models\Reseller;
use App\Models\Transaction;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function __construct()
    {
        $fOfCurrMonth = now()->firstOfMonth();
        $mOfCurrMonth = $fOfCurrMonth->copy()->addDays(14);

        $fOfPrevMonth = now()->subMonth()->firstOfMonth();
        $mOfPrevMonth = $fOfPrevMonth->copy()->addDays(14);
        $lOfPrevMonth = now()->subMonth()->lastOfMonth();

        $this->timezone = date('d') >= 1 && date('d') <= 15 ? [
            $mOfPrevMonth->addDay()->toDateTimeString(), $lOfPrevMonth->endOfDay()->toDateTimeString(),
        ] : [
            $fOfCurrMonth->toDateTimeString(), $mOfCurrMonth->endOfDay()->toDateTimeString(),
        ];
    }

    /**
     * Pay
     */
    public function pay()
    {
        $resellers = Reseller::with(['transactions', 'orders' => function ($query): void {
            $query->whereBetween('data->completed_at', $this->timezone)
                ->orWhereBetween('data->returned_at', $this->timezone);
        }])->get()->sortByDesc('balance');
        $resellers = $resellers->filter(function (Reseller $reseller) {
            $lastPaidAt = optional($reseller->lastPaid->created_at)->toDateString();
            if (! is_null($reseller->payment) && ($lastPaidAt <= $this->timezone[1])) {
                $com = $ret = 0;
                $reseller->orders
                    ->each(function (Order $item) use (&$com, &$ret): void {
                        if ($item->status === 'DELIVERED') {
                            $com += $item->data['profit'] - $item->data['advanced'];
                        } elseif ($item->status === 'FAILED') {
                            $ret += $item->data['delivery_charge'] + $item->data['packaging'] + $item->data['cod_charge'];
                        }
                    });
                $reseller->payNow = $com - $ret;
                if ($reseller->payNow !== 0) {
                    return $reseller;
                }
            }
        });

        // $resellers = $this->paginate($resellers, $resellers->count(), 10);
        return view('admin.transactions.pay', compact('resellers'));
    }

    public function paginate(Collection $results, $total, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        return $this->paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    /**
     * Pay To Reseller
     */
    public function payToReseller(Reseller $reseller)
    {
        return view('admin.transactions.payment-form', compact('reseller'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'reseller_id' => 'required|integer',
            'transaction_id' => 'nullable|integer',
            'amount' => 'required|integer',
            'method' => 'required',
            'bank_name' => 'nullable',
            'account_name' => 'nullable',
            'branch' => 'nullable',
            'routing_no' => 'nullable',
            'account_type' => 'required',
            'account_number' => 'required',
            'transaction_number' => 'required_if:transaction_id,0',
        ], [
            'transaction_number.required_if' => 'The transaction number field is required.',
        ]);

        // dd($data);
        $transaction_type = null;
        if ($id = $request->transaction_id) {
            $transaction = Transaction::findOrFail($id);
            $transaction->update([
                'transaction_number' => $request->transaction_number,
                'status' => 'paid',
            ]);
            $transaction_type = 'request';
        } else {
            $transaction = Transaction::create($data + ['status' => 'paid']);
        }

        event(new TransactionCompleted($transaction, $transaction_type, $this->timezone));

        return Redirect::route('admin.transactions.requests')->with('success', 'Transaction Details Stored.');
    }

    public function show(Transaction $transaction)
    {
        // $query = $transaction->reseller->orders()->whereIn('status', ['completed', 'returned']);
        // $orders = $query->where(function ($query) {
        //     return $query->whereBetween('data->completed_at', $this->timezone)
        //         ->orWhereBetween('data->returned_at', $this->timezone);
        // })->get();

        return view('admin.transactions.show', [
            'data' => $transaction->toArray(),
            'timezone' => $this->timezone,
            'orders' => $transaction->orders,
        ]);
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();

        return back();
    }
}
