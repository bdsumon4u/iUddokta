<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = cache('faqs', function () {
            $faqs = Faq::all();
            $faqs->each(function (Faq $faq): void {
                cache(["faq.{$faq->id}" => $faq]);
            });
            cache(['faqs' => $faqs]);

            return $faqs;
        });
        $faqs = Faq::all();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|max:255|unique:faqs',
            'answer' => 'required',
        ]);
        $faq = Faq::create($data);
        cache(["faq.{$faq->id}" => $faq]);
        cache(['faqs' => Faq::all()]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($faq)
    {
        $faq = cache("faq.{$faq}", fn() => Faq::findOrFail($faq));

        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|max:255|unique:faqs,id,'.$faq->id,
            'answer' => 'required',
        ]);
        $faq->update($data);
        cache(["faq.{$faq->id}" => $faq]);
        cache(['faqs' => Faq::all()]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Deleted Successfully.');
    }
}
