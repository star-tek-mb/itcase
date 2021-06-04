<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.static.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.static.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ru' => 'required'
        ]);

        Page::create($request->all());
        return redirect()->back()->with('success', 'Страница добавлена');
    }

    public function edit(Request $request, Page $page)
    {
        return view('admin.pages.static.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title.ru' => 'required'
        ]);

        $page->update($request->all());
        return redirect()->back()->with('success', 'Страница отредактирована');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('success', 'Страница удалена');
    }
}
