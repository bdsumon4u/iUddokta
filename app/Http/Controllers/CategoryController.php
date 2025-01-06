<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = cache('categories.formatted', function () {
            $formatted = Category::formatted();
            cache(['categories.formatted' => $formatted]);

            return $formatted;
        });

        // dd($categories);
        return view('admin.categories.index', compact('categories'));
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
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
            'parent_id' => 'integer|nullable',
        ]);

        Category::create($data);
        cache(['categories.formatted' => Category::formatted()]);

        return redirect()->back()->with('success', 'Category Has Created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories,id,'.$category->id,
            'slug' => 'required|unique:categories,id,'.$category->id,
            'parent_id' => 'integer|nullable',
        ]);

        $category->update($data);
        cache(['categories.formatted' => Category::formatted()]);

        return redirect()->back()->with('success', 'Category Has Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        if ($category->delete()) {
            cache(['categories.formatted' => Category::formatted()]);

            return redirect()->route('admin.categories.index')->with('success', 'Category Has Deleted.');
        }

        return redirect()->back();
    }
}
