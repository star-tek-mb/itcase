<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Helpers\PaginateCollection;
use App\Notifications\InviteRequest;
use App\Notifications\NewRequest;
use App\Notifications\RequestAction;
use App\Notifications\TenderCreated;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TenderController extends Controller
{

    /**
     * @var NeedTypeRepositoryInterface
     */
    private $needRepository;

    /**
     * @var TenderRepositoryInterface
     */
    private $tenderRepository;

    /**
     * @var HandbookCategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var MenuRepositoryInterface
     */
    private $menuItemsRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * TenderController constructor.
     * @param NeedTypeRepositoryInterface $needRepository
     * @param TenderRepositoryInterface $tenderRepository
     * @param HandbookCategoryRepositoryInterface $categoryRepository
     * @param MenuRepositoryInterface $menuItemsRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(NeedTypeRepositoryInterface $needRepository,
                                TenderRepositoryInterface $tenderRepository,
                                HandbookCategoryRepositoryInterface $categoryRepository,
                                MenuRepositoryInterface $menuItemsRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->needRepository = $needRepository;
        $this->tenderRepository = $tenderRepository;
        $this->categoryRepository = $categoryRepository;
        $this->menuItemsRepository = $menuItemsRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $tenders = $this->tenderRepository->allOrderedByCreatedAt();
        $currentCategory = null;
        $tendersCount = $tenders->count();
        $tenders = PaginateCollection::paginateCollection($tenders, 5);
        return response()->json([
            'tenders' => $tenders,
            'currentCategory' => $currentCategory,
            'tendersCount' => $tendersCount
        ]);
    }

    public function searchTender(Request $request)
    {
        $tenders = $this->tenderRepository->TenderSearch($request);
        $currentCategory = null;
        $tendersCount = $tenders->count();
        $tenders = PaginateCollection::paginateCollection($tenders, 5);
        return response()->json([
            'tenders' => $tenders,
            'currentCategory' => $currentCategory,
            'tendersCount' => $tendersCount
        ]);

    }

    public function category($category_id)
    {
        $currentCategory = $this->categoryRepository->get($category_id);
        if ($currentCategory) {
            $tenders = $currentCategory->tenders()->whereNotNull('owner_id')->where('published', true)->orderBy('opened', 'desc')->orderBy('created_at', 'desc')->get();
            $tendersCount = $tenders->count();
            $tenders = PaginateCollection::paginateCollection($tenders, 5);
            return response()->json([
                'tenders' => $tenders,
                'currentCategory'=>$currentCategory,
                'tendersCount'=>$tendersCount
            ]);
        } else {
            return response()->json([
                'message' => 'Ресурс не найден'
            ], 404);
        }
    }

    public function tender($id)
    {
        $tender = $this->tenderRepository->get($id)->load('categories');
        if ($tender) {
            return response()->json($tender);
        } else {
            return response()->json([
                'message' => 'Ресурс не найден'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validationMessages = [
            'required' => 'Это поле обязательно к заполнению',
            'max' => 'Количество символов должно быть не больше :max',
            'integer' => 'Укажите целочисленное значение',
            'date' => 'Неверный формат даты',
            'string' => 'Укажите стороковое значение',
            'email' => 'Неверный формат электронной почты'
        ];
        if (auth()->user())
            auth()->user()->authorizeRole('customer');
        Validator::make($request->all(), [
            'categories' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'files' => 'nullable',
            'budget' => 'required',
            'deadline' => 'required|date'
        ], $validationMessages)->validate();
        $tender = $this->tenderRepository->create($request);

        Notification::send($this->userRepository->getAdmins(), new TenderCreated($tender));
        return response()->json([
            'success' => "Тендер $tender->title создан и отправлен на модерацию!"
        ]);

    }

    public function makeRequest(Request $request)
    {
        $request->validate([
            'budget_from' => 'required|max:255',
            'budget_to' => 'required|max:255',
            'period_to' => 'required|max:255',
            'period_from' => 'required|max:255',
            'comment' => 'nullable|string|max:255'
        ]);
        $tenderRequest = $this->tenderRepository->createRequest($request);
        $tenderRequest->tender->owner->notify(new NewRequest($tenderRequest));
        $tenderTitle = $tenderRequest->tender->title;
        return response()->json([
            'success' =>  "Вы подали заявку на участие в конкурсе \"$tenderTitle\""
        ]);
    }

    public function cancelRequest(Request $request)
    {
        $requestId = $request->get('requestId');
        $rejected = $request->get('rejected') === 'true' ? true : false;
        $tenderRequest = $this->tenderRepository->cancelRequest($requestId);
        $tender = $this->tenderRepository->get($tenderRequest->tender_id);
        if ($rejected) {
            $tenderRequest->user->notify(new RequestAction('rejected', $tenderRequest, $tender));
            foreach (auth()->user()->chats as $chat) {
                if ($chat->getAnotherUser()->id === $tenderRequest->user_id) {
                    $chat->delete();
                    break;
                }
            }
        } else {
            foreach (auth()->user()->chats as $chat) {
                if ($chat->getAnotherUser()->id === $tender->owner_id) {
                    $chat->delete();
                    break;
                }
            }
        }
        if ($request->has('redirect_to')) {
            return response()->json([
                'success' =>  'Заявка отклонена.'
            ]);

        }
        return response()->json([
            'success' =>  'Ваша заявка отменена'
        ]);

    }

    public function update(Request $request, int $id)
    {
        $validationMessages = [
            'required' => 'Это поле обязательно к заполнению',
            'max' => 'Количество символов должно быть не больше :max',
            'integer' => 'Укажите целочисленное значение',
            'date' => 'Неверный формат даты',
            'string' => 'Укажите стороковое значение',
            'email' => 'Неверный формат электронной почты'
        ];
        Validator::make($request->all(), [
            'categories' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'files' => 'nullable',
            'budget' => 'required',
            'deadline' => 'required|date'
        ], $validationMessages)->validate();
        $this->tenderRepository->update($id, $request);
        return response()->json([
            'success' =>  'Конкрус отредактитрован!'
        ]);
    }

    public function delete(Request $request, int $id)
    {
        $this->tenderRepository->delete($id);
        return response()->json([
            'success' =>  'Конкурс удалён'
        ]);

    }

    public function acceptTenderRequest(Request $request, int $tenderId, int $requestId)
    {

        $redirectTo = $request->get('redirect_to');
        if ($request = $this->tenderRepository->acceptRequest($tenderId, $requestId)) {
            $request->user->notify(new RequestAction('accepted', $request));
            $requests = $request->tender->requests;

            foreach ($requests as $otherRequest) {
                if ($otherRequest->user_id == $request->user_id)
                    continue;
                $otherRequest->user->notify(new RequestAction('rejected', $otherRequest, $otherRequest->tender));
            }
            $adminUsers = $this->userRepository->getAdmins();
            Notification::send($adminUsers, new RequestAction('accepted', $request));
            return response()->json([
                'success' => 'Исполнитель на этот конкурс назначен! Администратор сайта с вами свяжется и вы получите инструкции, необходимые для того, чтобы исполнитель приступил к работе.'
            ]);
        } else {
            return response()->json([
                'success' => 'Невозможно назначить исполнителя на этот конкурс'
            ]);
        }
    }
}
