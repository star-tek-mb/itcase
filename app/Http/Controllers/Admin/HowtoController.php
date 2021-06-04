<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Howto;
use App\Http\Controllers\Controller;

class HowtoController extends Controller
{
    
    public function index()
    {
        $howtos = Howto::all();
        return view('admin.pages.howtos.index', compact('howtos'));
    }

    public function create()
    {
        return view('admin.pages.howtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ru' => 'required'
        ]);

        $howto = new Howto($request->all());
        if ($request->hasFile('image')){
            $howto->uploadImage($request->file('image'));
        }
        return redirect()->back()->with('success', 'Страница добавлена');
    }

    public function edit(Request $request, Howto $howto)
    {
        return view('admin.pages.howtos.edit', compact('howto'));
    }

    public function update(Request $request, Howto $howto)
    {
        $request->validate([
            'title.ru' => 'required'
        ]);

        $howto->update($request->all());
        if ($request->hasFile('image')){
            $howto->uploadImage($request->file('image'));
        }
        return redirect()->back()->with('success', 'Страница отредактирована');
    }

    public function destroy(Howto $howto)
    {
        $howto->delete();
        return redirect()->back()->with('success', 'Страница удалена');
    }
}
