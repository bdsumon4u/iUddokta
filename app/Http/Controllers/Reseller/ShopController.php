<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShopController extends Controller
{
    /**
     * Shop Index
     */
    public function index(Request $request)
    {
        $shops = auth('reseller')->user()->shops;

        return view('reseller.shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::allowIf(auth('reseller')->user()->shops->isEmpty(), 'You already have a shop.');

        return view('reseller.shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::allowIf(auth('reseller')->user()->shops->isEmpty(), 'You already have a shop.');
        tap($request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'website' => 'nullable',
            'inside_dhaka' => 'required|integer',
            'outside_dhaka' => 'required|integer',
        ]) + [
            'reseller_id' => auth('reseller')->user()->id,
        ], function ($data) use ($request) {

            if ($request->hasFile('logo')) {
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStore = $filename.time().'.'.$extension;
                $thumbnailpic = 'thumb'.'-'.$fileNameToStore;

                //This store image creates the folder and saves the file
                $path = $request->file('logo')->storeAs('public/shop', $fileNameToStore);

                // if(! is_dir($dir = public_path('shop'))) {
                //     mkdir($dir, 755);
                // }
                $to = 'shop/'.$thumbnailpic;

                //Here is where I am trying to resize with image and it breaks
                Image::make(storage_path().'/app/public/shop/'.$fileNameToStore)->resize(250, 66)->save(public_path($to));

                if (! empty($to)) {
                    Storage::delete(public_path($to));
                    unset($data['logo']);
                    $data += [
                        'logo' => $to,
                    ];
                }
            }

            $shop = Shop::create($data);
        });

        return redirect()->route('reseller.shops.index')->with('success', 'Shop Has Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('reseller.shop.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        tap($request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'website' => 'nullable',
        ]) + [
            'reseller_id' => auth('reseller')->user()->id,
        ], function ($data) use ($request, $shop) {

            if ($request->hasFile('logo')) {
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStore = $filename.time().'.'.$extension;
                $thumbnailpic = 'thumb'.'-'.$fileNameToStore;

                //This store image creates the folder and saves the file
                $path = $request->file('logo')->storeAs('public/shop', $fileNameToStore);

                // if(! is_dir($dir = public_path('shop'))) {
                //     mkdir($dir, 755);
                // }
                $to = 'shop/'.$thumbnailpic;

                //Here is where I am trying to resize with image and it breaks
                Image::make(storage_path().'/app/public/shop/'.$fileNameToStore)->resize(250, 66)->save(public_path($to));

                if (! empty($to)) {
                    Storage::delete(public_path($to));
                    unset($data['logo']);
                    $data += [
                        'logo' => $to,
                    ];
                }
            }

            $shop->update($data);
        });

        return redirect()->route('reseller.shops.index')->with('success', 'Shop Has Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
