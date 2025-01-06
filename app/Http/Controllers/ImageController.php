<?php

namespace App\Http\Controllers;

use App\Helpers\Traits\ImageHelper;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use ImageHelper;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();

        return view('admin.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): void
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');
        // $path = Storage::putFile('media', $file);
        $path = $this->uploadImage($file, ['dir' => 'images/products', 'height' => 600, 'width' => 600]);

        Image::create([
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->guessClientExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        if ($image->products->isEmpty()) {
            if (File::exists($path = public_path($image->path))) {
                if (unlink($path)) {
                    $image->delete();
                }
            } else {
                $image->delete();
            }

            return back()->with('success', 'Image Has Deleted.');
        }

        return redirect()->back()->with('error', 'Error! The Image Is In Use.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image): void
    {
        //
    }
}
