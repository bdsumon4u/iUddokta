<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResellerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Reseller::latest())
                ->addIndexColumn()
                ->addColumn('empty', fn($row): string => '')
                ->addColumn('name', fn($row): string => '<a href="'.route('admin.resellers.show', $row->id).'">'.$row->name.'</a>')
                ->addColumn('status', fn($row): string => '<span class="badge badge-'.($row->verified_at ? 'success' : 'secondary').'">'.($row->verified_at ? 'Verified' : 'Non-Verified').'</span>')
                ->addColumn('action', fn($row): string => '<form action="'.route('admin.resellers.destroy', $row->id).'" method="post">
                            <div class="btn-group btn-group-inline">
                                <a class="btn btn-sm btn-primary" target="_blank" href="'.route('admin.resellers.edit', $row->id).'">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </form>')
                ->rawColumns(['name', 'status', 'action'])
                ->setRowAttr([
                    'data-entry-id' => fn($row) => $row->id,
                ])
                ->make(true);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'edit') {
                $data = $request->validate([
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required',
                    'status' => 'required',
                ]);
                Reseller::findOrFail($request->id)->update($data);
            } elseif ($request->action == 'delete') {
                Reseller::findOrFail($request->id)->delete();
            }

            return response()->json($request);
        }
    }
}
