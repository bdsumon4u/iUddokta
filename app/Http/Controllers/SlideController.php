<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Traits\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    use ImageUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slides.index', [
            'slides' => Slide::all(),
        ]);
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
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');

        return Slide::create([
            'is_active' => true,
            'mobile_src' => $this->uploadImage($file, [
                'width' => config('services.slides.mobile.0', 360),
                'height' => config('services.slides.mobile.1', 180),
                'dir' => 'slides/mobile',
            ]),
            'desktop_src' => $this->uploadImage($file, [
                'width' => config('services.slides.desktop.0', 1125),
                'height' => config('services.slides.desktop.1', 395),
                'dir' => 'slides/desktop',
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $data = $request->validate([
            'title' => 'nullable|max:255',
            'text' => 'nullable|max:255',
            'btn_name' => 'nullable|max:20',
            'btn_href' => 'nullable|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $slide->update($data);

        return back()->with('success', 'Slide Has Been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        Storage::disk('public')->delete(Str::after($slide->mobile_src, 'storage'));
        Storage::disk('public')->delete(Str::after($slide->desktop_src, 'storage'));
        $slide->delete();

        return back()->with('success', 'Slide Has Been Deleted.');
    }
}
