<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\PaginateCollection;
use App\Notifications\InviteRequest;
use App\Notifications\RequestAction;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

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
            $mean = (int)collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        return response()->json([
            'contractors' => $contractors,
            'contractorsCount' => $contractorsCount
        ]);
    }

    public function contractorSearch(Request $request)
    {
        $contractors = $this->users->searchContractors($request);

        $contractorsCount = $contractors->count();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int)collect($comments)->avg('assessment');
            $contractor->mean = $mean;
            $contractor->categories = $contractor->categories->map(function ($categories) use ($contractor) {
                if ($contractor->pivot == null) {
                    $contractor->pivot = $categories->pivot;
                }
                return [
                    'ru_title' => $categories->ru_title,
                    'en_title' => $categories->en_title,
                    'uz_title' => $categories->uz_title,
                ];
            })->all();

        }
        return response()->json([
            'contractors' => $contractors,
            'contractorsCount' => $contractorsCount
        ]);
    }

    /**
     * Show contractors from category
     *
     * @param string $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function category(Request $request, int $category_id)
    {
        $category = $this->categories->get($category_id);
        if ($category) {
            $contractors = $category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at');
            $contractorsCount = $contractors->count();
            $contractors = PaginateCollection::paginateCollection($contractors, 5);
            foreach ($contractors as $contractor) {
                $comments = $this->users->getComments($contractor->id);
                $mean = (int)collect($comments)->avg('assessment');
                $contractor->mean = $mean;
                $contractor->categories = $contractor->categories->map(function ($categories) {
                    return [
                        'ru_title' => $categories->ru_title,
                        'en_title' => $categories->en_title,
                        'uz_title' => $categories->uz_title,
                    ];
                })->all();
            }

            return response()->json([
                'contractors' => $contractors,
                'contractorsCount' => $contractorsCount
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
        $contractor->comments = $this->users->getComments($contractor->id)->get()->map(function ($com) {
            $author = $com->author;
            $com->who_set = $author->first_name . " " . $author->last_name;
            return $com;
        });


        return response()->json([
            'contractor' => $contractor,
        ]);
    }

    public function addContractor(int $contractorId, int $tenderId)
    {
        $request = $this->tenders->addContractor($tenderId, $contractorId);
        try {
            $this->users->get($contractorId)->notify(new InviteRequest($request));
        } catch (\Exception $e) {
        }
        return response()->json([
            'success' => 'Исполнитель добавлен в конкурс!',
        ]);
    }

    public function acceptInvitation(Request $request)
    {
        $user = auth()->user();
        $tenderId = $request->tenderId;
        $tenderRequest = $user->requests()->where('tender_id', $tenderId)->where('invited', 1)->first();
        if ($tenderRequest) {
            $tender = $this->tenders->get($tenderId);
            $tender->contractor_id = $tenderRequest->user_id;
            $tender->opened = false;
            $tender->save();
            $tenderRequest->user->victories_count += 1;
            $tenderRequest->user->save();
            $requests = $tenderRequest->tender->requests;
            try {
                $tender->owner->notify(new RequestAction('accepted_by_contractor', $tenderRequest));
            } catch (\Swift_TransportException $e) {

            }


            foreach ($requests as $otherRequest) {
                if ($otherRequest->user_id == $user->id) {
                    continue;
                }
                try {
                    $otherRequest->user->notify(new RequestAction('rejected', $otherRequest, $tender));
                } catch (\Swift_TransportException $e) {

                }
            }

//            $adminUsers = $this->users->getAdmins();
//            Notification::send($adminUsers, new RequestAction('accepted_by_contractor', $tenderRequest));

            return response()->json([
                'success' => 'Вы приняли пришлашение. Скоро свами свяжуться'
            ], 200);
        } else {
            return response()->json([
                'success' => 'Невозможно назначить исполнителя на этот конкурс'
            ], 401);
        }
    }

    public function rejectInvitation(Request $request)
    {
        $user = auth()->user();
        $tenderId = $request->tenderId;
        $requestGet = $user->requests()->where('tender_id', $tenderId)->where('invited', 1)->first();
        try {
            $requestGet->tender->owner->notify(new RequestAction('rejected_by_contractor', $requestGet));
        } catch (\Swift_TransportException $e) {

        }
        $requestGet->delete();
        return response()->json([
            'success' => 'Вы успешно отклонили предложение'
        ], 200);
    }
}
