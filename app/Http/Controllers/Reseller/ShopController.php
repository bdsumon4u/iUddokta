<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

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
        return view('reseller.shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'website' => 'nullable',
        ]);

        $validatedData['reseller_id'] = auth('reseller')->user()->id;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileNameToStore = $file->hashName();
            $thumbnailName = 'thumb-'.$fileNameToStore;

            // Store the original logo
            $file->storeAs('public/shop', $fileNameToStore);

            // Create and store the thumbnail
            $originalPath = storage_path('app/public/shop/'.$fileNameToStore);
            $thumbnailPath = storage_path('app/public/shop/'.$thumbnailName);

            $image = Image::read($originalPath);
            $image->resize(250, 66);
            $image->save($thumbnailPath);

            $validatedData['logo'] = 'shop/'.$thumbnailName;
        }

        Shop::create($validatedData);

        return redirect()->route('reseller.shops.index')->with('success', 'Shop Has Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop): void
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'website' => 'nullable',
        ]);

        $validatedData['reseller_id'] = auth('reseller')->user()->id;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileNameToStore = $file->hashName();
            $thumbnailName = 'thumb-'.$fileNameToStore;

            // Store the original logo
            $file->storeAs('public/shop', $fileNameToStore);

            // Create and store the thumbnail
            $thumbnailPath = storage_path('app/public/shop/'.$thumbnailName);

            $image = Image::read($file);
            $image->resize(250, 66);
            $image->save($thumbnailPath);

            $validatedData['logo'] = 'shop/'.$thumbnailName;
        }

        $shop->update($validatedData);

        return redirect()->route('reseller.shops.index')->with('success', 'Shop Has Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop): void
    {
        //
    }
}
