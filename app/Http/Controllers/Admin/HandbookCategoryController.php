<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class HandbookCategoryController extends Controller
{
    /**
     * HandbookCategory repository
     *
     * @var HandbookCategoryRepositoryInterface
    */
    protected $handbookCategoryRepository;

    /**
     * Repository for types of needs
     *
     * @var NeedTypeRepositoryInterface
     */
    private $needTypesRepository;

    /**
     * Create a new instance
     *
     * @param HandbookCategoryRepositoryInterface $handbookCategoryRepository
     * @param NeedTypeRepositoryInterface $needTypesRepository
     * @return void
    */
    public function __construct(
        HandbookCategoryRepositoryInterface $handbookCategoryRepository,
        NeedTypeRepositoryInterface $needTypesRepository
    )
    {
        $this->handbookCategoryRepository = $handbookCategoryRepository;
        $this->needTypesRepository = $needTypesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'categories' => $this->handbookCategoryRepository->all()
        ];

        return view('admin.pages.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templateFiles = Storage::disk('catalog_templates')->allFiles();
        $templateStrings = array();
        foreach ($templateFiles as $file) {
            array_push($templateStrings, explode('.', $file)[0]);
        }

        $data = [
            'categories' => $this->handbookCategoryRepository->getTree(),
            'needs' => $this->needTypesRepository->all(),
            'templates' => $templateStrings
        ];

        return view('admin.pages.categories.create', $data);
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
            'ru_title' => 'required|max:255',
        ]);

        $category = $this->handbookCategoryRepository->store($request);
        $categoryMeta = $category->createMetaInformation();
        auth()->user()->addHistoryItem('category.create', $categoryMeta);
        if ($request->has('saveQuit')) {
            $parent = $category->getParentId();
            if ($parent != null) {
                return redirect()->route('admin.categories.show', $parent);
            } else {
                return redirect()->route('admin.categories.index');
            }
        } else {
            return redirect()->route('admin.categories.create');
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
            'category' => $this->handbookCategoryRepository->get($id)
        ];

        return view('admin.pages.categories.category', $data);
    }

    /**
     * Display category companies
     *
     * @param int $id Category Id
     * @return \Illuminate\Http\Response
    */
    public function companies(int $id)
    {
        $data = [
            'category' => $this->handbookCategoryRepository->get($id)
        ];

        return view('admin.pages.categories.companies', $data);
    }

    public function tenders(int $id)
    {
        $category = $this->handbookCategoryRepository->get($id);
        return view('admin.pages.categories.tenders', compact('category'));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $templateFiles = Storage::disk('catalog_templates')->allFiles();
        $templateStrings = array();
        foreach ($templateFiles as $file) {
            array_push($templateStrings, explode('.', $file)[0]);
        }
        $data = [
            'category' => $this->handbookCategoryRepository->get($id),
            'categories' => $this->handbookCategoryRepository->getTree(),
            'templates' => $templateStrings
        ];
        return view('admin.pages.categories.edit', $data);
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
        ]);
        $category = $this->handbookCategoryRepository->update($id, $request);
        $categoryMeta = $category->createMetaInformation();
        auth()->user()->addHistoryItem('category.update', $categoryMeta);

        $parentId = $category->getParentId();
        if ($parentId != null) {
            return redirect()->route('admin.categories.show', $parentId);
        } else {
            return redirect()->route('admin.categories.index');
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
        $categoryMeta = $this->handbookCategoryRepository->get($id)->createMetaInformation();
        auth()->user()->addHistoryItem('category.delete', $categoryMeta);

        $parent = $this->handbookCategoryRepository->delete($id);

        if ($parent != null && $this->handbookCategoryRepository->get($parent)->hasCategories()) {
            return redirect()->route('admin.categories.show', $parent);
        } else {
            return redirect()->route('admin.categories.index');
        }
    }

    /**
     * Remove image for category
     *
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function removeImage(int $id)
    {
        $category = $this->handbookCategoryRepository->get($id);
        $category->removeImage();

        return redirect()->back();
    }

    /**
     * Change position for category
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePosition(Request $request)
    {
        $categoryId = $request->get('id');
        $position = $request->get('position');
        if ($this->handbookCategoryRepository->setPosition($categoryId, $position)) {
            return Response::create("", 200);
        } else {
            return Response::create("", 400);
        }
    }
}
