<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = cache('pages', function () {
            $pages = Page::all();
            $pages->each(function ($page): void {
                cache(["page.{$page->slug}" => $page]);
            });
            cache(['pages' => $pages]);

            return $pages;
        });

        return view('admin.pages.index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:pages',
            'slug' => 'required|unique:pages',
            'content' => 'required',
        ]);

        $page = Page::create($data);
        cache(["page.{$page->slgu}" => $page]);
        cache(['pages' => Page::all()]);

        return redirect()->back()->with('success', 'Page Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        $page = cache("page.$page", fn () => Page::where('slug', $page)->get()->last());

        return view('page', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($page)
    {
        $page = cache("page.$page", fn () => Page::where('id', $page)->first());
        cache(['pages' => Page::all()]);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|unique:pages,id,'.$page->id,
            'slug' => 'required|unique:pages,id,'.$page->id,
            'content' => 'required',
        ]);
        $page->update($data);

        return redirect()->back()->with('success', 'Page Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $page->delete();

        return redirect()->back()->with('success', 'Page Deleted Successfull.');
    }
}
