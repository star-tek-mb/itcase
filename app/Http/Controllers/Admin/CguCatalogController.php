<?php

namespace App\Http\Controllers\Admin;

use App\Models\CguCatalog;
use App\Repositories\CguCatalogRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CguCatalogController extends Controller
{
    protected $catalogRepository;

    /**
     * CguCatalogController constructor.
     * @param CguCatalogRepositoryInterface $catalogRepository
     */
    public function __construct(CguCatalogRepositoryInterface $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'catalogs' => $this->catalogRepository->all()
        ];

        return view('admin.pages.cguCatalogs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => $this->catalogRepository->getTree()
        ];

        return view('admin.pages.cguCatalogs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catalog = $this->catalogRepository->store($request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgucatalogs.create');
        } else {
            return redirect()->route('admin.cgucatalogs.index');
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
            'catalog' => $this->catalogRepository->get($id),
            'categories' => $this->catalogRepository->getTree()
        ];

        return view('admin.pages.cguCatalogs.edit', $data);
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
        $catalog = $this->catalogRepository->update($id, $request);

        if ($request->has('save')) {
            return redirect()->route('admin.cgucatalogs.edit', $catalog->id);
        } else {
            return redirect()->route('admin.cgucatalogs.index');
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
        $this->catalogRepository->delete($id);

        return redirect()->route('admin.cgucatalogs.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFile($id)
    {
        $this->catalogRepository->removeFile($id);

        return redirect()->route('admin.cgucatalogs.edit', $id);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function changePosition(Request $request)
    {
        $catalog = $this->catalogRepository->get($request->get('id'));
        $catalog->position = $request->get('position');
        if ($catalog->save()) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed']);
        }
    }
}
