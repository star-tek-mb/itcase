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
    public function contractor(string $slug)
    {

        $contractor = $this->users->getContractorBySlug($slug);
        $portfolio = $this->users->getPortfolioBySlug($slug);
        $comments = $this->users->getCommentBySlug($slug);
        $mean = 0;
        foreach($comments as $comment_sum){
          $mean+=(int)$comment_sum->assessment;
        }
        if($mean!=0){
          $mean = $mean/count($comments);
        }

        abort_if(!$contractor, 404);
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

    public function addContractorForNonAuth(int $contractorId) {
        $user = $this->users->get($contractorId);
        $contractors = \Session::get('contractors', collect());
        if ($contractors->contains('id', $contractorId))
            return response()->json([
                'success'=>'back',
            ]);
        $contractors->push([
            'id' => $contractorId,
            'name' => $user->getCommonTitle(),
            'image' => $user->getImage()
        ]);
        \Session::put('contractors', $contractors);
        return response()->json([
            'contractors'=>$contractors,
        ]);
    }

    public function deleteContractorFromSession(int $contractorId) {
        $contractors = \Session::get('contractors');
        if (!$contractors->contains('id', $contractorId))
            return response()->json([
                'success'=>'back',
            ]);
        $contractors = $contractors->filter(function ($item) use ($contractorId) {
            return $item['id'] !== $contractorId;
        });
        if (count($contractors) === 0) {
            \Session::forget('contractors');
            \Session::save();
            return response()->json([
                'success'=>'back',
            ]);
        }
        \Session::put('contractors', $contractors);
        return response()->json([
            'contractors'=>$contractors,
        ]);
    }

    public function deleteAllContractorsFromSession() {
        \Session::forget('contractors');
        \Session::save();
        return response()->json([
            'success'=>'back',
        ]);
    }
}
