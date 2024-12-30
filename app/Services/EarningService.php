<?php

namespace App\Services;

use App\Models\Reseller;
use Carbon\Carbon;

class EarningService
{
    public $reseller;
    public $periods = [];
    public $timeFormat = 'd-M-Y';
    public $seperator = '--';
    public $orders;

    public $currentPeriod;
    public $nextTransactionPeriod;

    public function __construct($reseller)
    {
        $reseller instanceof Reseller || (
            $reseller = Reseller::findOrFail($reseller)
        );
        $periods = [];

        $created_at = $reseller->created_at;
        $date = $created_at->clone();

        while ($date->year <= date('Y')) {
            // First Month
            if ($date->year == $created_at->year && $date->month == $created_at->month) {
                if ($date->day <= 15) {
                    $periods[] = $this->firstHalf($date->firstOfMonth());
                }
                $periods[] = $this->lastHalf($date->firstOfMonth());
            }
            // Last Month
            else if ($date->year == date('Y') && $date->month == date('m')) {
                $periods[] = $this->firstHalf($date);
                date('d') <= 15 || (
                    $periods[] = $this->lastHalf($date)
                );
                break;
            }
            // Else
            else {
                $periods[] = $this->firstHalf($date);
                $periods[] = $this->lastHalf($date);
            }

            $date->addMonth();
        }

        $this->periods = $periods;
        $this->reseller = $reseller;
        $this->currentPeriod = end($periods);
        $this->nextTransactionPeriod();
    }

    public function firstHalf($date): string
    {
        return $date->format($this->timeFormat) . $this->seperator . $date->copy()->addDays(14)->format($this->timeFormat);
    }

    public function lastHalf($date): string
    {
        return $date->copy()->addDays(15)->format($this->timeFormat) . $this->seperator . $date->copy()->lastOfMonth()->format($this->timeFormat);
    }

    public function orders($period)
    {
        return $this->orders = $this->reseller->orders()
            ->where(function($query) use ($period) {
                list($start_date, $end_date) = explode($this->seperator, $period);
                $start_date = Carbon::parse($start_date);
                $end_date = Carbon::parse($end_date)->endOfDay();

                $query->whereBetween('data->completed_at', [$start_date, $end_date])
                    ->orWhereBetween('data->returned_at', [$start_date, $end_date]);
            })
            ->orderBy('updated_at', 'asc')
            ->get();
    }

    public function completedOrders()
    {
        if (! $this->orders) {
            return null;
        }

        return $this->orders->filter(function ($order) {
            return $order->status == 'DELIVERED';
        });
    }

    public function returnedOrders()
    {
        if (! $this->orders) {
            return null;
        }

        return $this->orders->filter(function ($order) {
            return $order->status == 'RETURNED';
        });
    }

    public function nextTransactionPeriod($currentPeriod = null)
    {
        $currentPeriod && (
        $this->currentPeriod = $currentPeriod
        );

        if (! $this->currentPeriod) {
            return null;
        }

        list($start_date, $end_date) = array_map(function ($date) {
            return Carbon::parse($date);
        }, explode($this->seperator, $this->currentPeriod));

        $fOfMon = $start_date->copy()->firstOfMonth();
        $mOfMon = $fOfMon->copy()->addDays(14);
        $lOfMon = $end_date->copy()->lastOfMonth();

        $fOfNextMon = $fOfMon->copy()->addMonth()->firstOfMonth();
        $mOfNextMon = $fOfNextMon->copy()->addDays(14);

        return $this->nextTransactionPeriod
            = $end_date->day > 15 ? [
            $fOfNextMon, $mOfNextMon->endOfDay(),
        ] : [
            $mOfMon->addDay(), $lOfMon->endOfDay(),
        ];
    }

    public function howPaid($currentPeriod = null)
    {
        $currentPeriod && (
        $this->nextTransactionPeriod($currentPeriod)
        );

        $transactions = $this->reseller->transactions()->status('paid')->whereBetween('updated_at', $this->nextTransactionPeriod)->get();
        return $transactions->isEmpty() ? null : $transactions->sum('amount');
    }
}
