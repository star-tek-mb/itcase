<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\VacancyCategory;
use App\Http\Controllers\Controller;

class VacancyCategoryController extends Controller
{
    
    public function index()
    {
        $data = VacancyCategory::all();
        return view('admin.pages.vacancyCategory.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pages.vacancyCategory.create');
    }

    public function store(Request $request)
    {
        VacancyCategory::create($request->all());
        return redirect()->back()->with('success', 'Категория добавлена');
    }

    public function edit(Request $request, VacancyCategory $vacancyCategory)
    {
        return view('admin.pages.vacancyCategory.edit')->with('category', $vacancyCategory);
    }

    public function update(Request $request, VacancyCategory $vacancyCategory)
    {
        $vacancyCategory->update($request->all());
        return redirect()->back()->with('success', 'Категория отредактирована');
    }

    public function destroy(VacancyCategory $vacancyCategory)
    {
        $vacancyCategory->delete();
        return redirect()->back()->with('success', 'Категория удалена');
    }
}
