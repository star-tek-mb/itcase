<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\MenuRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use App\Repositories\HandbookCategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    /**
     * Repository for menu items
     *
     * @var MenuRepositoryInterface
    */
    private $menuItems;

    /**
     * Repository for type of needs
     *
     * @var NeedTypeRepositoryInterface
    */
    private $needs;

    /**
     * Repository for categories
     *
     * @var HandbookCategoryRepositoryInterface
     */
    private $categories;

    /**
     * Create a new controller instance
     *
     * @param MenuRepositoryInterface $menuRepository
     * @param NeedTypeRepositoryInterface $needsRepository
     * @param HandbookCategoryRepositoryInterface $categoryRepository
     * @return void
    */
    public function __construct(
        MenuRepositoryInterface $menuRepository,
        NeedTypeRepositoryInterface $needsRepository,
        HandbookCategoryRepositoryInterface $categoryRepository
    )
    {
        $this->menuItems = $menuRepository;
        $this->needs = $needsRepository;
        $this->categories = $categoryRepository;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $needId = $request->get('needId', '1');
        $need = $this->needs->get($needId);
        $data = [
            'needId' => $needId,
            'need' => $need,
            'categories' => $this->categories->allWithoutTree()
        ];
        return view('admin.pages.menu.create', $data);
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
            'image' => 'nullable|image',
            'need_id' => 'required|numeric|gt:0'
        ]);
        $this->menuItems->create($request);

        $needId = $request->get('need_id');
        if ($request->has('saveQuit')) {
            return redirect()->route('admin.needs.menu', $needId);
        } else {
            return redirect()->route('admin.menu.create', ['needId' => $needId]);
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
        $menu = $this->menuItems->get($id);
        $categoriesIdsArray = $menu->getCategoriesIdsAsArray();
        $categories = $this->categories->allWithoutTree();

        return view('admin.pages.menu.edit', compact('menu', 'categoriesIdsArray', 'categories'));
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
            'image' => 'nullable|image',
            'need_id' => 'required|numeric|gt:0'
        ]);
        $this->menuItems->update($id, $request);
        $needId = $request->get('need_id');
        return redirect()->route('admin.needs.menu', $needId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $needId = $this->menuItems->delete($id);
        return redirect()->route('admin.needs.menu', $needId);
    }

    /**
     * Remove image for menu item
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function removeImage(int $id)
    {
        $menu = $this->menuItems->get($id);
        $menu->removeImage();

        return redirect()->back();
    }
}
