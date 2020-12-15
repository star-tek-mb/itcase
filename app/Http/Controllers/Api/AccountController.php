<?php

namespace App\Http\Controllers\Api;

use App\Notifications\TenderCreated;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use foo\bar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var HandbookCategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var TenderRepositoryInterface
     */
    private $tenderRepository;

    /**
     * @var NeedTypeRepositoryInterface
     */
    private $needsRepository;

    /**
     * AccountController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param HandbookCategoryRepositoryInterface $categoryRepository
     * @param TenderRepositoryInterface $tenderRepository
     * @param NeedTypeRepositoryInterface $needsRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                HandbookCategoryRepositoryInterface $categoryRepository,
                                TenderRepositoryInterface $tenderRepository,
                                NeedTypeRepositoryInterface $needsRepository)
    {
        $this->middleware(['auth:sanctum', 'verified']);
        $this->middleware('account.completed')->except(['create', 'store']);

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
        $user = auth()->user();
        if ($user->hasRole('contractor')) {
            $accountPage = 'personal';
            return response()->json([
                'user' => $accountPage
            ]);
        }
        else if ($user->hasRole('customer')) {
            if ($user->customer_type == 'company') $accountPage = 'company';
            else $accountPage = 'personal';
            return response()->json([
                'user' => $accountPage
            ]);
        }
        else
            abort(403);
    }

    public function store(Request $request)
    {
        $userType = $request->get('user_role');
        $user = auth()->user();
        $validationMessages = [
            'required' => 'Это поле обязательно к заполнению',
            'max' => 'Количество символов должно быть не больше :max',
            'integer' => 'Укажите целочисленное значение',
            'date' => 'Неверный формат даты',
            'string' => 'Укажите стороковое значение',
            'email' => 'Неверный формат электронной почты',
            $userType . '_email.unique' => 'Такая электронная почта уже зарегистрирована'
        ];
        $validator = Validator::make($request->all(), [
            $userType . '_name' => ['required', 'string', 'max:255'],
            $userType . '_phone_number' => ['required', 'string'],
            'contractor_birthday_date' => Rule::requiredIf($userType == 'contractor' && $request->get('contractor_type') == 'individual'),
            $userType . '_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            $userType . '_about_myself' => ['required', 'string'],
            $userType . '_company_name' => Rule::requiredIf($request->get('customer_type') == 'legal_entity'),
            'agree_personal_data_processing' => 'required|boolean'
        ], $validationMessages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }
        $this->userRepository->createAccount($request);
        return response()->json([
            'message' => 'Ваш аккаунт создан'
        ]);
    }


    public function savePersonalContractor(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('contractor');
        $validationMessages = [
            'required' => 'Это поле обязательно к заполнению',
            'max' => 'Количество символов должно быть не больше :max',
            'integer' => 'Укажите целочисленное значение',
            'date' => 'Неверный формат даты',
            'string' => 'Укажите стороковое значение',
            'email' => 'Неверный формат электронной почты'
        ];
        Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'about_myself' => 'required|string|max:5000',
            'company_name' => Rule::requiredIf($user->contractor_type == 'agency'),
            'phone_number' => 'required'
        ], $validationMessages)->validate();
        $this->userRepository->update($user->id, $request);
        return response()->json([
            'message' => 'Ваши личные данные обновлены'
        ]);
    }

    public function professional()
    {

        $user = auth()->user();
        $user->authorizeRole('contractor');
        $chosenSpecs = $user->categories()->pluck('category_id')->toArray();
        $accountPage = 'professional';
        $categories = $this->categoryRepository->all()->load('categories');
        return response()->json([
            'user' => $user,
            'accountPage' => $accountPage,
            'chosenSpecs' => $chosenSpecs,
            'categories' => $categories,
        ]);

    }

    public function saveProfessional(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('contractor');
        
        $categories = collect();
        foreach ($request->get('categories') as $requestCategory)
            if (isset($requestCategory['id']))
                $categories->push($requestCategory);
        if ($categories->count() == 0) {
            return response()->json([
                'message' => 'Укажите услуги, которые вы предоставляете'
            ]);
        }
        $needs = $this->needsRepository->all();
        $selectedNeedsCount = 0;
        $categoryIds = $categories->pluck('id')->toArray();
        foreach ($needs as $need) {
            $menuItems = $need->menuItems;
            foreach ($menuItems as $menuItem) {
                if ($menuItem->categories()->whereIn('handbook_categories.id', $categoryIds)->count() > 0) {
                    $selectedNeedsCount++;
                    break;
                }
            }
        }
        if ($selectedNeedsCount >= 3)
            return response()->json([
                'message' =>  'Извините, мы не даём возможность выбирать категории из всех сфер деятельности. Вы можете выбрать максимум две сферы. Например, из сферы IT и Мультимедия, Бизнес и Маркетинг. Комбинации не ограничены'
            ]);

        foreach ($categories as $category) {
            if (!isset($category['price_from']) || !isset($category['price_to'])
            || empty($category['price_from']) || empty($category['price_to'])) {
                return response()->json([
                    'message' =>  'Укажите цены на каждую выбранную услугу']);
            }
        }
        $user->categories()->detach();
        foreach ($categories as $category) {
            $user->categories()->attach($category['id'],
                ['price_to' => $category['price_to'],
                    'price_from' => $category['price_from'],
                    'price_per_hour' => $category['price_per_hour']]
            );
        }

        return response()->json([
            'message' =>  'Ваши профессиональные данные обновлены']);
    }

    public function saveCustomerProfile (Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('customer');
        $validationMessages = [
            'required' => 'Это поле обязательно к заполнению',
            'max' => 'Количество символов должно быть не больше :max',
            'integer' => 'Укажите целочисленное значение',
            'date' => 'Неверный формат даты',
            'string' => 'Укажите стороковое значение',
            'email' => 'Неверный формат электронной почты'
        ];
        Validator::make($request->all(), [
            'image' => 'required|image',
            'company_name' => [Rule::requiredIf($user->customer_type == 'company')],
            'about_myself' => 'required|string|max:5000',
            'foundation_year' => 'nullable|integer',
            'site' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'name' => 'required|max:255'
        ], $validationMessages)->validate();

        $this->userRepository->update($user->id, $request);

        return response()->json([
            'message' =>  'Ваш профиль обновлён']);
    }

    public function editTender(string $slug)
    {
        $user = auth()->user();
        $tender = $user->ownedTenders()->where('slug', $slug)->first();
        $accountPage = 'tenders';
        abort_if(!$tender, 404);
        return response()->json([
            'user'=>$user ,
            'accountPage'=>$accountPage,
            'tender'=>$tender
        ]);

    }

    public function tenderCandidates (string $slug) {
        $user = auth()->user();
        $tender = $user->ownedTenders()->where('slug', $slug)->first();
        abort_if(!$tender, 404);
        $accountPage = 'tenders';
        return response()->json([
            'user'=>$user ,
            'accountPage'=>$accountPage,
            'tender'=>$tender
        ]);
    }


}
