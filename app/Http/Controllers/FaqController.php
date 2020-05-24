<?php

namespace App\Http\Controllers;

use App\Faq;
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
            $faqs->each(function (Faq $faq) {
                cache(["faq.{$faq->id}" => $faq]);
            });
            cache(['faqs' => $faqs]);
            return $faqs;
        });
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
     * @param  \Illuminate\Http\Request  $request
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
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($faq)
    {
        $faq = cache("faq.{$faq}", function () use ($faq) {
            return Faq::findOrFail($faq);
        });
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|max:255|unique:faqs,id,' . $faq->id,
            'answer' => 'required',
        ]);
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Deleted Successfully.');
    }
}
