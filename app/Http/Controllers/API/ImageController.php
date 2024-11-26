<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Image::latest()->get())
                ->addIndexColumn()
                ->addColumn('empty', function ($row) {
                    return '';
                })
                ->addColumn('preview', function ($row) {
                    return '<img src="'.asset($row->path).'" class="img-preview img-responsive img-thumbnail" width="150" height="150">';
                })
                ->addColumn('size', function ($row) {
                    return bytesToHuman($row->size);
                })
                ->addColumn('delete', function ($row) {
                    $btn = '<a href="'.route('admin.images.show', $row->id).'" class="select-item btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="" class="select-item btn btn-light btn-sm">Select</a>';

                    return $btn;
                })
                ->rawColumns(['preview', 'delete', 'action'])
                ->setRowAttr([
                    'data-entry-id' => function ($row) {
                        return $row->id;
                    },
                ])
                ->make(true);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'IDs' => 'required|array',
            'IDs.*' => 'required|integer',
        ], [
            'IDs.*.required' => 'Each ID must be integer.',
        ]);

        $images = Image::whereIn('id', $data['IDs'])->get();
        foreach ($images as $image) {
            // dump(storage_path($image->path));
            if ($image->products->isEmpty()) {
                if (File::exists($path = public_path($image->path))) {
                    if (unlink($path)) {
                        $image->delete();
                    }
                } else {
                    $image->delete();
                }
            }
        }

        return true;
    }
}
