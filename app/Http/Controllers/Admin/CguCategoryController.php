<?php

namespace App\Http\Controllers\Admin;

use App\Models\CguCategory;
use App\Repositories\CguCategoryRepository;
use App\Repositories\CguCategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CguCategoryController extends Controller
{
    protected $cguCategoryRepository;

    /**
     * CguCategoryController constructor.
     * @param CguCategoryRepositoryInterface $category
     */
    public function __construct(CguCategoryRepositoryInterface $category)
    {
        $this->cguCategoryRepository = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'categories' => $this->cguCategoryRepository->all(),
        ];

        return view('admin.pages.cguCategories.index', $data);
    }

    public function sites($id)
    {
        $data = [
            'category' => $this->cguCategoryRepository->get($id)
        ];

        return view('admin.pages.cguCategories.sites', $data);
    }


    public function removeImage($id)
    {
        $category = CguCategory::find($id);
        $category->removeImage();

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => $this->cguCategoryRepository->getTree()
        ];


        return view('admin.pages.cguCategories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ru_title' => 'required|unique:cgu_categories|max:255',
            'image'    => 'nullable|image',
//            'ru_slug' => 'unique:cgu_categories|max:255',
//            'en_slug' => 'unique:cgu_categories|max:255',
//            'uz_slug' => 'unique:cgu_categories|max:255',
        ]);


        $category = $this->cguCategoryRepository->store($request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgucategories.create');
        } else {
            return redirect()->route('admin.cgucategories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'category' => $this->cguCategoryRepository->get($id),
        ];

        return view('admin.pages.cguCategories.category', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function files($id)
    {
        $data = [
            'category' => $this->cguCategoryRepository->get($id),
        ];

        return view('admin.pages.cguCategories.files', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'categories' => $this->cguCategoryRepository->getTree(),
            'category' => $this->cguCategoryRepository->get($id)
        ];

        return view('admin.pages.cguCategories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ru_title' => 'required|max:255',
            'image'    => 'nullable|image'
        ]);

        $category = $this->cguCategoryRepository->update($id, $request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgucategories.edit', $category->id);
        } else {
            return redirect()->route('admin.cgucategories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = $this->cguCategoryRepository->delete($id);

        if ($parent != null && $this->cguCategoryRepository->get($parent)->hasCategories()) {
            return redirect()->route('admin.cgucategories.show', $parent);
        } else {
            return redirect()->route('admin.cgucategories.index');
        }
    }

    public function changePosition(Request $request)
    {
        $category = CguCategory::find($request->get('id'));
        $category->position = $request->get('position');
        if ($category->save()) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }
}
