<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SlugHelper;
use App\Http\Controllers\Helpers\PaginateCollection;
use App\Notifications\InviteRequest;
use App\Notifications\RequestAction;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
    public  function acceptInvitation(Request $request){
        $user = auth()->user();
        $tenderId = $request->tenderId;
        $request = $user->requests()->where('tender_id',$tenderId)->where('invited', 1)->get();
        if ($request){
            $tender = $this->tenders->get($tenderId);
            $tender->contractor_id = $request->user_id;
            $tender->opened = false;
            $tender->save();
            $request->user->victories_count += 1;
            $request->user->save();
            $requests = $request->tender->requests;
            try {
                foreach ($requests as $otherRequest) {
                    if ($otherRequest->user_id == $request->user_id) {
                        continue;
                    }
                    $otherRequest->user->notify(new RequestAction('rejected', $otherRequest, $otherRequest->tender));
                }
                $adminUsers = $this->users->getAdmins();

                Notification::send($adminUsers, new RequestAction('accepted', $request));
            } catch (\Swift_TransportException $e) {

            }
            return response()->json([
                'success' => 'Исполнитель на этот конкурс назначен! Администратор сайта с вами свяжется и вы получите инструкции, необходимые для того, чтобы исполнитель приступил к работе.'
            ],200);
        } else {
            return response()->json([
                'success' => 'Невозможно назначить исполнителя на этот конкурс'
            ],401);
        }
    }

    public  function  rejectInvitation(Request $request){
        $user = auth()->user();
        $tenderId = $request->tenderId;
        $requestGet = $user->requests()->where('tender_id',$tenderId)->where('invited', 1)->first();
        $requestGet->delete();
        return response()->json([
            'success' => 'Вы успешно отклонили предложение'
        ],200);
    }
}
