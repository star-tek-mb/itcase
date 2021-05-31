<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\VacancyCategory;
use App\Http\Controllers\Controller;

class VacancyController extends Controller
{
    
    public function index()
    {
        $data = Vacancy::all();
        return view('admin.pages.vacancy.index', compact('data'));
    }

    public function create()
    {
        $categories = VacancyCategory::all();
        return view('admin.pages.vacancy.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required',
            'vacancy_category_id' => 'required'
        ]);
        $vacancy = new Vacancy($request->all());
        $vacancy->user_id = auth()->user()->id;
        $vacancy->save();
        return redirect()->back()->with('success', 'Вакансия добавлена');
    }

    public function edit(Request $request, Vacancy $vacancy)
    {
        $categories = VacancyCategory::all();
        return view('admin.pages.vacancy.edit', compact('vacancy', 'categories'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'city' => 'required',
            'vacancy_category_id' => 'required'
        ]);
        $vacancy->update($request->all());
        return redirect()->back()->with('success', 'Вакансия отредактирована');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return redirect()->back()->with('success', 'Вакансия удалена');
    }
}
