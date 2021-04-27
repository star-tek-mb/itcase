<?php

namespace App\Http\Controllers\Api;

use App\Models\HandbookCategory;
use App\Notifications\TenderCreated;
use App\Repositories\HandbookCategoryRepository;
use App\Repositories\NeedTypeRepository;
use App\Repositories\TenderRepository;
use App\Repositories\UserRepository;
use App\Services\OctoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Helpers\PaginateCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

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
     * @param UserRepository $userRepository
     * @param HandbookCategoryRepository $categoryRepository
     * @param TenderRepository $tenderRepository
     * @param NeedTypeRepository $needsRepository
     */
    public function __construct(
        UserRepository $userRepository,
        HandbookCategoryRepository $categoryRepository,
        TenderRepository $tenderRepository,
        NeedTypeRepository $needsRepository
    )
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
    public function index(int $user_id)
    {

        if ($user_id == 0) {
            $user = auth()->user();
            $permission = true;
        } else {
            $owner_id = auth()->user()->id;
            $user = $this->userRepository->get($user_id);
            $permission = $this->tenderRepository->checkPermission($owner_id, $user_id);
        }
        if ($user->hasRole('contractor')) {
            $accountPage = 'personal';
            return response()->json([
                'accountPage' => $accountPage,
                'user' => $user,
                'role' => 'contractor',
                'permission' => $permission,
            ]);
        } elseif ($user->hasRole('customer')) {
            if ($user->customer_type == 'legal_entity') {
                $accountPage = 'company';
            } else {
                $accountPage = 'personal';
            }
            return response()->json([
                'accountPage' => $accountPage,
                'user' => $user,
                'role' => 'customer',
                'permission' => $permission,
            ]);
        } else {
            abort(403);
        }
    }

    public function create(Request $request, OctoService $octo)
    {
        $user = auth()->user();
        $user->dynamic = false;
        if ($request->has('dynamicUrl')) {
            $user->dynamic = true;
        }

        $paymentUrl = $octo->requestPayment($user);
        return response()->json(compact('user', 'paymentUrl'));
    }

    public function store(Request $request)
    {
        $userType = $request->get('user_role');
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            $userType . '_first_name' => ['required', 'string', 'max:255'],
            $userType . '_last_name' => ['required', 'string', 'max:255'],
            $userType . '_phone_number' => ['required', 'string'],
            'contractor_birthday_date' => Rule::requiredIf($userType == 'contractor' && $request->get('contractor_type') == 'individual'),
            $userType . '_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            $userType . '_about_myself' => ['required', 'string'],
            $userType . '_company_name' => Rule::requiredIf($request->get('customer_type') == 'legal_entity'),
            $userType . '_city' => 'required|string',
            'image' => 'required|image',
            'agree_personal_data_processing' => 'required|accepted'
        ]);
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'about_myself' => 'required|string|max:5000',
            'company_name' => Rule::requiredIf($user->contractor_type == 'legal_entity'),
            'phone_number' => 'required',
            'city' => 'required',
            'newPassword' => 'nullable|min:6|required_with:newPasswordRepeat|same:newPasswordRepeat',
            'newPasswordRepeat' => 'nullable|min:6',
            'currentPassword' => 'nullable|password|required_with:newPassword',
            'resume' => 'sometimes|mimes:jpeg,pdf,jpg',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }
        $this->userRepository->update($user->id, $request);
        return response()->json([
            'message' => 'Ваши личные данные обновлены'
        ]);
    }
    public  function changePassword(Request $request){
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'newPassword' => 'nullable|min:6|required_with:newPasswordRepeat|same:newPasswordRepeat',
            'newPasswordRepeat' => 'nullable|min:6',
            'currentPassword' => 'required|password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }
        $user->password =  Hash::make($request->newPassword);
        $user->save();
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
        if ($request->isMethod('post')) {
            $user = auth()->user();
            $user->roles()->attach(Role::where('name', 'contractor')->first()->id);
            $categories = collect();
            foreach ($request->get('categories') as $requestCategory) {
                if (isset($requestCategory['id'])) {
                    $categories->push($requestCategory);
                }
            }
            if ($categories->count() == 0) {
                return response()->json([
                    'message' => 'Укажите услуги, которые вы предоставляете'
                ]);
            }
            $categoryIds = $categories->pluck('id')->toArray();

            if ($this->categoryRepository->getNumberOfCategories($categoryIds) > 4) {
                return response()->json([
                    'message' => 'Извините, мы не даём возможность выбирать категории из всех сфер деятельности. Вы можете выбрать максимум две сферы. Например, из сферы IT и Мультимедия, Бизнес и Маркетинг. Комбинации не ограничены'
                ]);
            }

            foreach ($categories as $category) {
                if (!isset($category['price_from']) || !isset($category['price_to'])
                    || empty($category['price_from']) || empty($category['price_to'])) {
                    return response()->json([
                        'message' => 'Укажите цены на каждую выбранную услугу']);
                }
            }

            $user->categories()->detach();
            foreach ($categories as $category) {
                $user->categories()->attach(
                    $category['id'],
                    ['price_to' => $category['price_to'],
                        'price_from' => $category['price_from'],
                        'price_per_hour' => $category['price_per_hour']]
                );
            }

            return response()->json([
                'message' => 'Ваши профессиональные данные обновлены']);
        }
    }

    public function saveCustomerProfile(Request $request)
    {
        $user = auth()->user();
        $user->authorizeRole('customer');
        $validator = Validator::make($request->all(), [
//            'image' => 'required|image',
            'company_name' => [Rule::requiredIf($user->customer_type == 'legal_entity')],
            'about_myself' => 'required|string|max:5000',
            'foundation_year' => 'nullable|integer',
            'site' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'city' => 'required',
            'newPassword' => 'nullable|min:6|required_with:newPasswordRepeat|same:newPasswordRepeat',
            'newPasswordRepeat' => 'nullable|min:6',
            'currentPassword' => 'nullable|password|required_with:newPassword',
            'resume' => 'sometimes|mimes:jpeg,pdf,jpg',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }

        $this->userRepository->update($user->id, $request);

        return response()->json([
            'message' => 'Ваш профиль обновлён']);
    }

    public function guestTenders(int $user_id)
    {
        $user = $this->userRepository->get($user_id);
        $tenders = $user->ownedTenders()->where('published', true)->orderBy('created_at', 'desc')->paginate(5);
        $tendersCount = $tenders->total();
        return response()->json([
            'tenders' => $tenders,
            'tendersCount' => $tendersCount
        ]);
    }
  // for inviting contractors
    public function shortTenders(int $contractorID)
    {
        $user = auth()->user();
        $tenders = $user->ownedTenders()->where('published', true)->where('opened', 1)
            ->whereDate('deadline', '>', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->get()->reject(function ($tender) use ($contractorID) {
                return $tender->requests()->where('user_id', '=', $contractorID)->count() > 0;
            })->map(function ($tender) {
                return [
                    'id' => $tender->id,
                    'title' => $tender->title
                ];
            });
//        $tenders = $user->ownedTenders()->select('id','title')->join('tender_requests', 'tender_requests.tender_id', '=','tenders.id')->where('user_id', '!=', $contractorID)

        if ($user) {
            return response()->json([
                'tenders' => $tenders,
            ]);
        } else {
            abort(404);
        }
    }


    public function tenders()
    {

        $user = auth()->user();
        $tenders = $user->ownedTenders()->where('published', true)->where('opened', 1)->whereDate('deadline', '>', Carbon::now())->orderBy('created_at', 'desc')->paginate(5);
        $tendersCount = $user->ownedTenders->count();
        if ($user) {
            return response()->json([
                'tenders' => $tenders,
                'tendersCount' => $tendersCount
            ]);
        } else {
            abort(404);
        }
    }

    public function finishedTenders()
    {
        $user = auth()->user();

        $tenders = $user->ownedTenders()->whereNotNull('delete_reason')->where(function ($query) {
            return $query->orWhereDate('deadline', '<', Carbon::now())->orWhere('opened', '=', 0);
        })->orderBy('created_at', 'desc')->paginate(5);
        $tendersCount = $tenders->count();

        if ($user) {
            return response()->json([
                'tenders' => $tenders,
                'tendersCount' => $tendersCount
            ]);
        } else {
            abort(404);
        }
    }

    public function onModerationTenders()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'tenders' => $user->ownedTenders()->where('published', false)->where('opened', 1)->whereNull('delete_reason')->whereDate('deadline', '>', Carbon::now())->orderBy('created_at', 'desc')->paginate(5)
            ]);
        } else {
            abort(404);
        }
    }

    public function requestsAccepted()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $response = $user->requests()->select('tenders.*')->join('tenders', 'tenders.id', '=', 'tender_requests.tender_id')->where('contractor_id', '=', $user_id)->paginate(5);
        $tendersCount = $response->count();
        return response()->json([
            'tenders' => $response,
            'tendersCount' => $tendersCount
        ]);
    }

    public function requestsSend()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $response = $user->requests()->select('tenders.*')->join('tenders', 'tenders.id', '=', 'tender_requests.tender_id')->where('contractor_id', '!=', $user_id)->paginate(5);

        return response()->json([
            'tenders' => $response,
        ]);
    }
}
