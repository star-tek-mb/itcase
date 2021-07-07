<?php

namespace App\Http\Controllers\Site;

use App\Notifications\TenderCreated;
use App\Repositories\HandbookCategoryRepository;
use App\Repositories\NeedTypeRepository;
use App\Repositories\TenderRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var HandbookCategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TenderRepository
     */
    private $tenderRepository;

    /**
     * @var NeedTypeRepository
     */
    private $needsRepository;

    /**
     * AccountController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param HandbookCategoryRepositoryInterface $categoryRepository
     * @param TenderRepositoryInterface $tenderRepository
     * @param NeedTypeRepositoryInterface $needsRepository
     */
    public function __construct(
        UserRepository $userRepository,
        HandbookCategoryRepository $categoryRepository,
        TenderRepository $tenderRepository,
        NeedTypeRepository $needsRepository
    )
    {
        $this->middleware(['auth', 'verified'])->except(['telegramCallback']);
        $this->middleware('account.completed')->except(['create', 'store', 'telegramCallback', 'markNotificationsAsRead']);

        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tenderRepository = $tenderRepository;
        $this->needsRepository = $needsRepository;
    }

    /**
     * Show main account page
     *
     * @return Factory|View
     */
    public function index()
    {
        return $this->viewPage('site.pages.account.customer.index');
    }

    public function viewPage($templateName)
    {
        $user = auth()->user();
        if ($user->hasRole('contractor')) {
            $accountPage = 'personal';
            return view('site.pages.account.contractor.index', compact('user', 'accountPage'));
        } elseif ($user->hasRole('customer')) {
            if ($user->customer_type == 'legal_entity') {
                $accountPage = 'company';
            } else {
                $accountPage = 'personal';
            }
            return view($templateName, compact('user', 'accountPage'));
        } else {
            abort(403);
        }
    }



    public function create(Request $request)
    {
        $user = auth()->user();
        if ($user->checkCompletedAccount()) {
            return redirect()->route('site.account.index');
        }
        $paymentUrl = $request->url;
        return view('site.pages.account.create', compact('user', 'paymentUrl'));
    }

    public function store(Request $request)
    {
        $userType = $request->get('user_role');
        $user = auth()->user();
        Validator::make($request->all(), [
            $userType . '_first_name' => ['required', 'string', 'max:255'],
            $userType . '_last_name' => ['required', 'string', 'max:255'],
            $userType . '_phone_number' => ['required', 'string'],
            'contractor_birthday_date' => Rule::requiredIf($userType == 'contractor' && $request->get('contractor_type') == 'individual'),
            $userType . '_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            $userType . '_about_myself' => ['required', 'string'],
            $userType . '_company_name' => Rule::requiredIf($request->get('customer_type') == 'legal_entity'),
            'image' => 'required|image',
            'agree_personal_data_processing' => 'required|accepted',
            'agree_tos' => 'required|accepted'
        ])->validate();
        $this->userRepository->createAccount($request);

        if ($userType == 'contractor') {
            return redirect()->route('phone.verification.notice')->with('account.success', 'Ваш аккаунт создан! Подтвердите номер телефона и заполните свои профессиональные данные, что бы вас могли найти в каталоге');
        }
        return redirect()->route('phone.verification.notice');
    }

    public function savePersonalContractor(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('contractor');
        Validator::make($request->all(), [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'about_myself' => 'required|string|max:5000',
            'company_name' => Rule::requiredIf($user->contractor_type == 'legal_entity'),
            'phone_number' => 'required',
            'newPassword' => 'nullable|min:6|required_with:newPasswordRepeat|same:newPasswordRepeat',
            'newPasswordRepeat' => 'nullable|min:6',
            'currentPassword' => 'nullable|password|required_with:newPassword',
            'resume' => 'sometimes|mimes:jpeg,pdf,jpg',
            'city' => 'required'
        ])->validate();
        $this->userRepository->update($user->id, $request);
        if (!$user->hasVerifiedPhone()) {
            return redirect()->route('phone.verification.notice')->with('message', 'Ваши личные данные обновлены');
        }

        return redirect()->route('site.account.index')->with('account.success', 'Ваши личные данные обновлены');
    }

    public function professional()
    {
        $user = auth()->user();
        $user->authorizeRole('contractor');
        $chosenSpecs = $user->categories()->pluck('category_id')->toArray();
        $accountPage = 'professional';
        $categories = $this->categoryRepository->all();

        return view(
            'site.pages.account.contractor.professional',
            compact('categories', 'user', 'accountPage', 'chosenSpecs')
        );
    }

    public function saveProfessional(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('contractor');
        $categories = collect();
        foreach ($request->get('categories') as $requestCategory) {
            if (isset($requestCategory['id'])) {
                $categories->push($requestCategory);
            }
        }
        if ($categories->count() == 0) {
            return back()->with('account.error', 'Укажите услуги, которые вы предоставляете');
        }
        // TODO: removed check count
        foreach ($categories as $category) {
            if (!isset($category['price_from']) || !isset($category['price_to'])
                || empty($category['price_from']) || empty($category['price_to'])) {
                return back()->with('account.error', 'Укажите цены на каждую выбранную услугу');
            }
        }

        $user->categories()->detach();
        foreach ($categories as $category) {
            $user->categories()->attach($category['id'], [
                'price_to' => $category['price_to'],
                'price_from' => $category['price_from'],
                'price_per_hour' => $category['price_per_hour']
            ]);
        }
        return redirect()->route('site.account.contractor.professional')->with('account.success', 'Ваши профессиональные данные обновлены');
    }

    public function saveCustomerProfile(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('customer');
        Validator::make($request->all(), [
            'image' => 'nullable|image',
            'company_name' => [Rule::requiredIf($user->customer_type == 'legal_entity')],
            'about_myself' => 'nullable|string|max:5000',
            'foundation_year' => 'nullable|integer',
            'site' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'newPassword' => 'nullable|min:6|required_with:newPasswordRepeat|same:newPasswordRepeat',
            'newPasswordRepeat' => 'nullable|min:6',
            'currentPassword' => 'nullable|password|required_with:newPassword',
            'city' => 'required',
        ])->validate();
        $this->userRepository->update($user->id, $request);
        if (!$user->hasVerifiedPhone()) {
            return redirect()->route('phone.verification.notice')->with('message', 'Ваш профиль обновлен');
        }

        return redirect()->route('site.account.index')->with('account.success', 'Ваш профиль обновлён');
    }

    public function tenders()
    {
        $user = auth()->user();
        $accountPage = 'tenders';
        if ($user->hasRole('customer')) {
            return \view('site.pages.account.customer.tenders', compact('user', 'accountPage'));
        } else {
            abort(404);
        }
    }

    public function tendersRequests()
    {
        $user = auth()->user();
        $accountPage = 'tenders';
        if ($user->hasRole('contractor')) {
            return \view('site.pages.account.contractor.tenders', compact('user', 'accountPage'));
        } else {
            abort(404);
        }
    }

    public function editTender(string $slug)
    {
        $user = auth()->user();
        $tender = $user->ownedTenders()->where('slug', $slug)->first();
        $accountPage = 'tenders';
        abort_if(!$tender, 404);
        return \view('site.pages.account.customer.editTender', compact('user', 'tender', 'accountPage'));
    }

    public function tenderCandidates(string $slug)
    {
        $user = auth()->user();
        $tender = $user->ownedTenders()->where('slug', $slug)->first();
        abort_if(!$tender, 404);
        $accountPage = 'tenders';
        return \view('site.pages.account.customer.candidates', compact('user', 'accountPage', 'tender'));
    }

    public function telegramCallback(Request $request)
    {
        if ($this->checkTelegramAuthorization($request->all())) {
            $telegramId = $request->get('id');
            $user = $this->userRepository->getUserByTelegramId((int)$telegramId);
            if (!$user) {
                $user = $this->userRepository->createUserViaTelegram($request);
            }
            \Auth::loginUsingId($user->id);
            return redirect()->route('site.account.index');
        } else {
            return back()->with('error', __('Ошибка при попытке авторизации через Telegram'));
        }
    }

    private function checkTelegramAuthorization($auth_data)
    {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        sort($data_check_arr);

        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        if (strcmp($hash, $check_hash) !== 0 || (time() - $auth_data['auth_date']) > 86400) {
            return false;
        }
        return true;
    }

    public function markNotificationsAsRead(Request $request)
    {
        if ($request->has('id')) {
            auth()->user()->unreadNotifications->where('id', $request->get('id'))->markAsRead();
        } else {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return \Response::make('', 204);
    }
}
