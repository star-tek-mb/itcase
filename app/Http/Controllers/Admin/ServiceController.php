<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Service repository
     *
     * @var ServiceRepositoryInterface
    */
    private $services;

    /**
     * Category repository
     *
     * @var HandbookCategoryRepositoryInterface
    */
    private $categories;

    /**
     * Create a new controller instance
     *
     * @param ServiceRepositoryInterface $serviceRepository
     * @param HandbookCategoryRepositoryInterface $categoryRepository
     * @return void
    */
    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        HandbookCategoryRepositoryInterface $categoryRepository
    )
    {
        $this->services = $serviceRepository;
        $this->categories = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->services->all();

        return view('admin.pages.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories->all();
        return view('admin.pages.services.create', compact('categories'));
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
            'ru_title' => 'required|unique:services|max:255',
        ]);

        $this->services->create($request);

        if ($request->has('saveQuit')) {
            return redirect()->route('admin.services.index');
        }
        return redirect()->route('admin.services.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->services->get($id);
        $categories = $this->categories->all();
        return view('admin.pages.services.edit', compact('categories', 'service'));
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
        $this->services->update($id, $request);

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->services->delete($id);

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove image action
     *
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function removeImage(int $id)
    {
        $service = $this->services->get($id);
        $service->removeImage();
        return redirect()->back();
    }
}
