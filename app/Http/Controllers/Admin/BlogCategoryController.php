<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogCategoryRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    protected $blogCategoryRepository;

    /**
     * CguCategoryController constructor.
     * @param BlogCategoryRepositoryInterface $category
     */
    public function __construct(BlogCategoryRepositoryInterface $category)
    {
        $this->blogCategoryRepository = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $data = [
            'categories' => $this->blogCategoryRepository->all(),
        ];

        return view('admin.pages.blog.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.pages.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'ru_title' => 'required|unique:blog_categories|max:255',
        ]);

        $this->blogCategoryRepository->store($request);

        if ($request->has('save')) {
            return redirect()->route('admin.blogcategories.create');
        } else {
            return redirect()->route('admin.blogcategories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $data = [
            'category' => $this->blogCategoryRepository->get($id)
        ];

        return view('admin.pages.blog.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ru_title' => 'required|max:255',
        ]);

        $category = $this->blogCategoryRepository->update($id, $request);

        if ($request->has('save')) {
            return redirect()->route('admin.blogcategories.edit', $category->id);
        } else {
            return redirect()->route('admin.blogcategories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->blogCategoryRepository->delete($id);
        return redirect()->route('admin.blogcategories.index');
    }
}
