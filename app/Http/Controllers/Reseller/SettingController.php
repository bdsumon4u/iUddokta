<?php

namespace App\Http\Controllers\Reseller;

use App\Helpers\Traits\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ImageHelper;

    public function edit()
    {
        $user = auth('reseller')->user();

        return view('reseller.setting.edit', compact('user'));
    }

    public function profile(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required',
            'photo' => 'nullable|image',
            'nid.front' => 'nullable|image',
            'nid.back' => 'nullable|image',
        ]);
        $reseller = \Auth::guard('reseller')->user();

        if ($reseller->verified_at == null) {
            $data['documents']['photo'] = isset($data['photo'])
                ? $this->uploadImage($data['photo'], [
                    'dir' => 'documents',
                    'width' => 150,
                    'height' => 150,
                ])
                : optional($reseller->documents)->photo;

            $data['documents']['nid_front'] = isset($data['nid']['front'])
                ? $this->uploadImage($data['nid']['front'], [
                    'dir' => 'documents',
                    'width' => 322,
                    'height' => 222,
                ])
                : optional($reseller->documents)->nid_front;

            $data['documents']['nid_back'] = isset($data['nid']['back'])
                ? $this->uploadImage($data['nid']['back'], [
                    'dir' => 'documents',
                    'width' => 322,
                    'height' => 222,
                ])
                : optional($reseller->documents)->nid_back;
        }

        $reseller->update($data);

        return redirect()->back()->with('success', 'Profile Updated.');
    }

    public function payment(Request $request)
    {
        $data = $request->validate([
            'payment' => 'required|array',
            'payment.*' => 'required|array',
        ]);
        \Auth::guard('reseller')->user()->update([
            'payment' => $this->payment_filter($data['payment']),
        ]);

        return back()->with('success', 'Payment Method Updatd.');
    }

    public function update(Request $request): never
    {
        dd($request->all());
    }

    public function payment_filter($payment)
    {
        $items = [];
        foreach ($payment as $item) {
            if (isset($item['method']) && ! empty($item['method']) && isset($item['type']) && ! empty($item['type']) && isset($item['number']) && ! empty($item['number'])) {
                if ($item['method'] == 'Bank') {
                    if (! isset($item['bank_name']) || empty($item['bank_name']) || ! isset($item['account_name']) || empty($item['account_name'])) {
                        continue;
                    }
                }
                $items[] = $item;
            }
        }

        return $items;
    }
}
