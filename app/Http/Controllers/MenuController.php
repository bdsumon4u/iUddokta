<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hmenus.index')->withMenus(Menu::all());
    }

    /**
     * Show the form for creating a new resource.
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
            'name' => 'required',
            'class' => 'nullable',
        ]);
        Menu::create($data);

        return back()->with('success', 'Menu Created.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $hmenu)
    {
        $items = $hmenu->items()->orderBy('order')->get();

        return view('admin.hmenus.show', compact('hmenu', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Menu  $menu
     */
    public function update(Request $request, $menu): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $hmenu)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $hmenu->delete();

        return back()->with('success', 'Menu Deleted.');
    }
}
