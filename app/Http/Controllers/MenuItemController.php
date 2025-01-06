<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): void
    {
        //
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id' => 'required|integer',
            'title' => 'required',
            'url' => 'required',
        ]);
        MenuItem::create($data);

        return back()->with('success', 'Menu Item Created.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $menuItem): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);
        $menuItem->update($data);

        return back()->with('success', 'Menu Item Updated.');
    }

    public function sort(Request $request, Menu $menu)
    {
        foreach ($request->positions as $position) {
            $menu->items()->find($position[0])->update(['order' => $position[1]]);
        }

        return response()->json(['success', 'SUCCESS']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $menuItem->delete();

        return back()->with('success', 'Menu Item Deleted.');
    }
}
