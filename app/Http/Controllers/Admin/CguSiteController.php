<?php

namespace App\Http\Controllers\Admin;

use App\Models\CguSite;
use App\Repositories\CguSiteRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CguSiteController extends Controller
{
    protected $siteRepository;

    /**
     * CguSiteController constructor.
     * @param CguSiteRepositoryInterface $cguSiteRepository
     */
    public function __construct(CguSiteRepositoryInterface $cguSiteRepository)
    {
        $this->siteRepository = $cguSiteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'sites' => $this->siteRepository->all()
        ];

        return view('admin.pages.cguSites.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => $this->siteRepository->getCategoriesTree()
        ];

        return view('admin.pages.cguSites.create', $data);
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
            'ru_title' => 'required|unique:cgu_sites|max:255',
            'ru_description' => 'nullable',
            'en_description' => 'nullable',
            'uz_description' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $site = $this->siteRepository->store($request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgusites.create');
        } else {
            return redirect()->route('admin.cgusites.index');
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
        //
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
            'site' => $this->siteRepository->get($id),
            'categories' => $this->siteRepository->getCategoriesTree()
        ];

        return view('admin.pages.cguSites.edit', $data);
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
            'image' => 'image',
        ]);

        $site = $this->siteRepository->update($id, $request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgusites.edit', $site->id);
        } else {
            return redirect()->route('admin.cgusites.index');
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
        $this->siteRepository->delete($id);

        return redirect()->route('admin.cgusites.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage($id)
    {
        $site = $this->siteRepository->get($id);
        $site->removeImage();

        return redirect()->route('admin.cgusites.edit', $site->id);
    }

    public function changePosition(Request $request)
    {
        $category = CguSite::find($request->get('id'));
        $category->position = $request->get('position');
        if ($category->save()) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }
}
