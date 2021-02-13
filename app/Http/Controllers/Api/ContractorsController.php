<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SlugHelper;
use App\Http\Controllers\Helpers\PaginateCollection;
use App\Notifications\InviteRequest;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractorsController extends Controller
{

    /**
     * Users repository
     *
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * Category repository
     *
     * @var HandbookCategoryRepositoryInterface
     */
    private $categories;

    /**
     * @var TenderRepositoryInterface
     */
    private $tenders;

    /**
     * @var MenuRepositoryInterface
     */
    private $menu;

    /**
     * ContractorsController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param HandbookCategoryRepositoryInterface $categoriesRepository
     * @param TenderRepositoryInterface $tenderRepository
     * @param MenuRepositoryInterface $menuRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                HandbookCategoryRepositoryInterface $categoriesRepository,
                                TenderRepositoryInterface $tenderRepository,
                                MenuRepositoryInterface $menuRepository)
    {
        $this->users = $userRepository;
        $this->categories = $categoriesRepository;
        $this->tenders = $tenderRepository;
        $this->menu = $menuRepository;
    }

    /**
     * Show all categories
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categories->all();
        $contractors = collect();
        foreach($categories as $category){
            $contractors = $contractors->merge($category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at'));
        }
        $contractorsCount = $contractors->count();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        return response()->json([
            'contractors'=>$contractors,
            'contractorsCount'=>$contractorsCount
        ]);


    }

    public function contractorSearch(Request $request){
      $categories = $this->categories->all();
      foreach($categories as $category){

      }
      $contractors = $this->users->searchContractors($request);

      $contractorsCount = $contractors->count();
      $contractors = PaginateCollection::paginateCollection($contractors, 5);
      return response()->json([
            'category'=>$category,
            'contractors'=>$contractors,
            'contractorsCount'=>$contractorsCount
        ]);
    }

    /**
     * Show contractors from category
     *
     * @param string $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function category(Request $request, $category_id)
    {
        $category = $this->categories->get($id);
        if ($category) {
            $contractors = $category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at');
            $contractorsCount = $contractors->count();
            $contractors = PaginateCollection::paginateCollection($contractors, 5);
            return response()->json([
                'category'=>$category,
                'contractors'=>$contractors,
                'contractorsCount'=>$contractorsCount
            ]);
        } else {
            return response()->json([
                'message' => 'Ресурс не найден'
            ], 404);
        }
    }


    /**
     * Show concrete contractor
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contractor($id)
    {
        $contractor = $this->users->get($id)->load('categories');
        if (!$contractor || !$contractor->hasRole('contractor')) {
            return response()->json([
                'message' => 'Ресурс не найден'
            ], 404);
        }
        $portfolio = $this->users->getPortfolioBySlug($contractor->slug);
        $comments = $this->users->getCommentBySlug($contractor->slug);
        $mean = (int) collect($comments)->avg('assessment');

        return response()->json([
            'contractor'=>$contractor,
            'portfolio'=>$portfolio,
            'comments'=>$comments,
            'mean'=>$mean
        ]);
    }

    public function addContractor(int $contractorId, int $tenderId) {
        $request = $this->tenders->addContractor($tenderId, $contractorId);
        $this->users->get($contractorId)->notify(new InviteRequest($request));
        return response()->json([
            'success'=>'Исполнитель добавлен в конкурс!',
        ]);
    }

}
