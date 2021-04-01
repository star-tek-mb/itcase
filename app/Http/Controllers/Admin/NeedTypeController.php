<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\NeedTypeRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class NeedTypeController extends Controller
{
    /**
     * Repository for types of needs
     *
     * @var NeedTypeRepositoryInterface
    */
    private $needTypesRepository;

    /**
     * Create a new controller instance
     *
     * @param NeedTypeRepositoryInterface $needTypesRepository
     * @return void
    */
    public function __construct(NeedTypeRepositoryInterface $needTypesRepository)
    {
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
            'needs' => $this->needTypesRepository->all()
        ];

        return view('admin.pages.needs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.needs.create');
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
        $this->needTypesRepository->create($request);

        if ($request->has('saveQuit')) {
            return redirect()->route('admin.needs.index');
        } else {
            return redirect()->route('admin.needs.create');
        }
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
            'need' => $this->needTypesRepository->get($id)
        ];

        return view('admin.pages.needs.edit', $data);
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
        $this->needTypesRepository->update($id, $request);

        return redirect()->route('admin.needs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->needTypesRepository->delete($id);

        return redirect()->route('admin.needs.index');
    }

    /**
     * Show menu for type of need
     *
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function menu(int $id)
    {
        $need = $this->needTypesRepository->get($id);
        return view('admin.pages.needs.menu', compact('need'));
    }

    /**
     * Change position for type of need
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
    */
    public function changePosition(Request $request)
    {
        $needId = $request->get('id');
        $position = $request->get('position');
        $this->needTypesRepository->changePosition($needId, $position);
        return Response::create('', 200);
    }
}
