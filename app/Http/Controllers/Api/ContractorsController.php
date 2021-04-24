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
    public function __construct(
        UserRepositoryInterface $userRepository,
        HandbookCategoryRepositoryInterface $categoriesRepository,
        TenderRepositoryInterface $tenderRepository,
        MenuRepositoryInterface $menuRepository
    )
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
        foreach ($categories as $category) {
            $contractors = $contractors->merge($category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at'));
        }
        $contractorsCount = $contractors->count();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int) collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        return response()->json([
            'contractors'=>$contractors,
            'contractorsCount'=>$contractorsCount
        ]);
    }

    public function contractorSearch(Request $request)
    {
        $contractors = $this->users->searchContractors($request);

        $contractorsCount = $contractors->count();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int) collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        return response()->json([
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
    public function category(Request $request,int $category_id)
    {
        $category = $this->categories->get($category_id);
        if ($category) {
            $contractors = $category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at');
            $contractorsCount = $contractors->count();
            $contractors = PaginateCollection::paginateCollection($contractors, 5);
            foreach ($contractors as $contractor) {
                $comments = $this->users->getComments($contractor->id);
                $mean = (int) collect($comments)->avg('assessment');
                $contractor->mean = $mean;
                $contractor->categories = $contractor->categories->map(function ($categories){
                    return [
                        'ru_title' => $categories->ru_title,
                        'en_title' => $categories->en_title,
                        'uz_title' => $categories->uz_title,
                    ];
                })->all();
            }

            return response()->json([
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
    public function contractor(int $id)
    {
        $contractor = $this->users->get($id)->load('categories');
        if (!$contractor || !$contractor->hasRole('contractor')) {
            return response()->json([
                'message' => 'Ресурс не найден'
            ], 404);
        }
        $contractor->portfolio = $this->users->getPortfolioBySlug($contractor->slug);
        $contractor->comments = $this->users->getComments($contractor->id)->get()->map(function ($com){
            $author = $com->author;
            $com->who_set = $author->first_name . " " . $author->last_name;
            return $com;
        });


        return response()->json([
            'contractor'=>$contractor,
        ]);
    }

    public function addContractor(int $contractorId, int $tenderId)
    {
        $request = $this->tenders->addContractor($tenderId, $contractorId);
        try {
            $this->users->get($contractorId)->notify(new InviteRequest($request));
        } catch (\Exception $e) {}
        return response()->json([
            'success'=>'Исполнитель добавлен в конкурс!',
        ]);
    }
}
