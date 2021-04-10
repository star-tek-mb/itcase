<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Helpers\PaginateCollection;
use App\Http\Requests\Tender\EmailSubscriptionRequest;
use App\Models\Tender;
use App\Models\Visit;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MenuItem;

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
    public function __construct(
        NeedTypeRepositoryInterface $needRepository,
        TenderRepositoryInterface $tenderRepository,
        HandbookCategoryRepositoryInterface $categoryRepository,
        MenuRepositoryInterface $menuItemsRepository,
        UserRepositoryInterface $userRepository
    )
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

        return view('site.pages.tenders.index', compact('tenders', 'currentCategory', 'tendersCount'));
    }

    public function searchTender(Request $request)
    {
        $tenders = $this->tenderRepository->TenderSearch($request);
        $currentCategory = null;
        $tendersCount = $tenders->count();
        $tenders = PaginateCollection::paginateCollection($tenders, 5);
        return view('site.pages.tenders.index', compact('tenders', 'currentCategory', 'tendersCount'));
    }

    public function category(string $params)
    {
        if (preg_match('/[A-Z]/', $params)) {
            return redirect(route('site.tenders.category', strtolower($params)), 301);
        }
        if (substr_count($params, 'tenders') > 1) {
            $paramsArray = array_slice(explode('/', $params)); // remove locale
            $uniqueParams = array_unique($paramsArray);
            return redirect(route('site.tenders.category', implode('/', $uniqueParams)), 301);
        }
        $paramsArray = array_slice(explode('/', $params), 1); // remove locale
        $tenders = collect();
        $currentCategory = null;
        if (count($paramsArray) === 1) {
            $menuItemSlug = $paramsArray[0];
            $menuItem = $this->menuItemsRepository->getBySlug($menuItemSlug);
            if ($menuItem) {
                if ($menuItem->ru_slug !== $params) {
                    return redirect(route('site.tenders.category', $menuItem->ru_slug), 301);
                }
                foreach ($menuItem->categories as $category) {
                    $tenders = $tenders->merge($category->tenders()->whereNotNull('owner_id')->where('published', true)->orderBy('opened', 'desc')->orderBy('created_at', 'desc')->get());
                }
                $tenders = $tenders->unique(function ($item) {
                    return $item->id;
                });
                $currentCategory = $menuItem;
                $tendersCount = $tenders->count();
                $tenders = PaginateCollection::paginateCollection($tenders, 5);
                return view('site.pages.tenders.index', compact('tenders', 'currentCategory', 'tendersCount'));
            }
            $tender = $this->tenderRepository->getBySlug($menuItemSlug);
            if ($tender) {
                if ($tender->slug !== $params) {
                    return redirect(route('site.catalog.tenders', $tender->slug), 301);
                }
                if ($tender->showTender()) {
                    $tender->setRelation('requests', $tender->requests()->paginate(1));
                    return view('site.pages.tenders.show', compact('tender'));
                }
                $tender->increment('views');
                Visit::createVisitLog($tender);
                $tender->setRelation('requests', $tender->requests()->paginate(1));
                return view('site.pages.tenders.show', compact('tender'));
            }
            abort(404, "Ресурс не найден");
        } else {
            $categorySlug = end($paramsArray);
            $currentCategory = $this->categoryRepository->getBySlug($categorySlug);
            if ($currentCategory) {
                if ($currentCategory->getAncestorsSlugs() !== $params) {
                    return redirect(route('site.tenders.category', $currentCategory->getAncestorsSlugs()), 301);
                }
                $tenders = $currentCategory->tenders()->whereNotNull('owner_id')->where('published', true)->orderBy('opened', 'desc')->orderBy('created_at', 'desc')->get();
                $tendersCount = $tenders->count();
                $tenders = PaginateCollection::paginateCollection($tenders, 5);
                return view('site.pages.tenders.index', compact('tenders', 'currentCategory', 'tendersCount'));
            } else {
                abort(404, "Ресурс не найден");
            }
        }
    }

    public function show(string $slug)
    {
        $tender = $this->tenderRepository->getBySlug($slug);
        abort_if(!$tender, 404);
        $tender->setRelation('requests', $tender->requests()->paginate(1));
        return view('site.pages.tenders.show', compact('tender'));
    }

    public function create()
    {
        $user = auth()->user();
        if ($user) {
            $user->authorizeRole('customer');
        } else {
            return redirect(route('register'))->with('warning', __('Для данного действия необходима регистрация'));
        }
        return view('site.pages.tenders.common.create');
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
        if (auth()->user()) {
            auth()->user()->authorizeRole('customer');
        }
        Validator::make($request->all(), [
            'categories' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'files' => 'nullable',
            'budget' => 'required',
            'deadline' => 'required|date',
            'geo_location' => 'nullable'
        ], $validationMessages)->validate();
        $tender = $this->tenderRepository->create($request);

        if (!Auth::check()) {
            if (session()->has('contractors')) {
                $contractors = session('contractors');
                foreach ($contractors as $contractor) {
                    $request = $tender->requests()->create(['user_id' => $contractor['id'], 'invited' => true]);
                    User::find($contractor['id'])->notify(new InviteRequest($request));
                }
                session()->forget('contractors');
                session()->save();
            }
            return redirect()->route('register')->withCookie(cookie('tenderId', "$tender->id"))->with('success', 'Ваш тендер сохранён и будет отправлен на модерацию только после регистрации');
        }
        Notification::send($this->userRepository->getAdmins(), new TenderCreated($tender));
        return redirect()->route('site.account.tenders')->with('success', "Тендер $tender->title создан и отправлен на модерацию!");
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
        return back()->with('success', "Вы подали заявку на участие в конкурсе \"$tenderTitle\"");
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
            return redirect($request->get('redirect_to'))->with('account.success', 'Заявка отклонена.');
        }
        return back()->with('success', 'Ваша заявка отменена');
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
            'deadline' => 'required|date',
            'geo_location' => 'nullable'
        ], $validationMessages)->validate();
        $this->tenderRepository->update($id, $request);
        return redirect($request->get('redirect_to'))->with('account.success', 'Конкрус отредактитрован!');
    }

    public function delete(Request $request, int $id)
    {
        $this->tenderRepository->delete($id, $request->delete_reason);

        return redirect($request->get('redirect_to'))->with('account.success', 'Конкурс удалён');
    }

    public function acceptTenderRequest(Request $request, int $tenderId, int $requestId)
    {
        $redirectTo = $request->get('redirect_to');
        if ($request = $this->tenderRepository->acceptRequest($tenderId, $requestId)) {
            $request->user->notify(new RequestAction('accepted', $request));
            $requests = $request->tender->requests;

            foreach ($requests as $otherRequest) {
                if ($otherRequest->user_id == $request->user_id) {
                    continue;
                }
                $otherRequest->user->notify(new RequestAction('rejected', $otherRequest, $otherRequest->tender));
            }
            $adminUsers = $this->userRepository->getAdmins();
            Notification::send($adminUsers, new RequestAction('accepted', $request));
            return redirect()->route('site.account.chats.create');
        // return redirect($redirectTo)->with('account.success', 'Исполнитель на этот конкурс назначен! Администратор сайта с вами свяжется и вы получите инструкции, необходимые для того, чтобы исполнитель приступил к работе.');
        } else {
            return redirect($redirectTo)->with('account.error', 'Невозможно назначить исполнителя на этот конкурс');
        }
    }

    public function emailSubscription(EmailSubscriptionRequest $request, Tender $tender)
    {
        $tender->update([
            'email_subscription' => $request->email_subscription
        ]);

        return redirect()->back();
    }

    public function ajaxFilter()
    {
        $minPrice = empty(request('min_price')) ? 0 : (int)(request('min_price'));
        $category_ids = request('category');
        $remote = request('remote') == 'on' ? 'remote' : null;
        $distance = request('distance');
        $location = request('location');
        $map = request('map_filter');
        $location = empty($location) ? "41.31064707835609, 69.2795380845336" : $location;

        if (empty($map)) {
            if (!empty($category_ids)) {
                $currentCategory = $this->categoryRepository->get(current($category_ids));
                $categories = $this->categoryRepository->get($category_ids);
            } else {
                $categories = $this->categoryRepository->allWithoutTree();
            }

            if ($categories) {
                $tenders = collect();
                $currentCategory = null;
                foreach ($categories as $category) {
                    $tenders = $tenders->merge($category->tenders()
                        ->whereNotNull('owner_id')
                        ->where('published', true)
                        ->where('type', $remote)
                        ->where('budget', '>', $minPrice)
                        ->orderBy('opened', 'desc')
                        ->get());
                }
                $tenders = $tenders->unique(function ($item) {
                    return $item->id;
                });

                $tendersCount = $tenders->count();
                $tenders = PaginateCollection::paginateCollection($tenders, 5);
                $tenders->withPath('');
                return view('site.pages.tenders.components.ajax-result', compact('tenders', 'currentCategory', 'tendersCount'));
            }
        } else {
            if (!empty($category_ids)) {
                $categories = $this->categoryRepository->get($category_ids);
            } else {
                $categories = $this->categoryRepository->allWithoutTree();
            }

            $tenders = collect();
            $currentCategory = null;
            foreach ($categories as $category) {
                $tenders = $tenders->merge($category->tenders()
                    ->whereNotNull('owner_id')
                    ->whereNotNull('geo_location')
                    ->where('published', true)
                    ->where('type', $remote)
                    ->where('budget', '>', $minPrice)
                    ->orderBy('opened', 'desc')
                    ->get());
            }
            $tenders = $tenders->unique(function ($item) {
                return $item->id;
            });
            $tendersCount = $tenders->count();
            return view('site.pages.tenders.components.ajax-map', compact('tenders', 'location', 'distance', 'tendersCount'));
        }
    }

    public function maps()
    {
        $tenders = $this->tenderRepository->allOrderedByCreatedAt(false, true);
        $currentCategory = null;
        $tendersCount = $tenders->count();
        $tenders = PaginateCollection::paginateCollection($tenders, 5);

        return view('site.pages.tenders.maps', compact('tenders', 'currentCategory', 'tendersCount'));
    }
}
