<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.index')->with('pages',Page::orderby('id','desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.create')->with('page',null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'title' => 'required|array',
            'text' => 'required|array',
     
        ]);
        Page::create($data);
        return redirect()->route('pages.index')->with('success',__('تم إضافة الصفحة بنجاح.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('dashboard.pages.create')->with('page',$page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'text' => 'required|array',
     
        ]);
        $page->update($data);
        return redirect()->route('pages.index')->with('success',__('تم تحديث الصفحة بنجاح.'));
    }

   
}
