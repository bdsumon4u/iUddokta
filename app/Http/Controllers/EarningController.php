<?php

namespace App\Http\Controllers;

use App\Services\EarningService;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'reseller_id' => 'required|integer',
            'period' => 'required',
        ]);

        $service = new EarningService($data['reseller_id']);

        return view(auth('reseller')->check() ? 'reseller.earning-status' : 'admin.resellers.earning-status', [
            'period' => $data['period'],
            'periods' => $service->periods,
            'orders' => $service->orders($data['period']),
            'howPaid' => $service->howPaid($data['period']),
        ]);
    }
}
