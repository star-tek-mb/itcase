<?php

namespace App\Http\Controllers\Site;

use App\Helpers\SlugHelper;
use App\Http\Controllers\Helpers\PaginateCollection;
use App\Models\Tender;
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
    ) {
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
        $contractors = $contractors->unique(function ($item) {
            return $item->id;
        });
        $contractorsCount = $contractors->count();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int)collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        $category = null; // main page

        return view('site.pages.contractors.index', compact('category', 'contractors', 'contractorsCount'));
    }

    public function contractorSearch(Request $request)
    {
        $categories = $this->categories->all();
        foreach ($categories as $category) {
        }
        $contractors = $this->users->searchContractors($request);

        $contractorsCount = $contractors->total();
        $contractors = PaginateCollection::paginateCollection($contractors, 5);
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int)collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        $category = null;
        return view('site.pages.contractors.index', compact('category', 'contractors', 'contractorsCount'));
    }

    public function contractorCategory(Request $request)
    {
        $contractors = $this->users->categoriesContractors($request);
        $contractorsCount = $contractors->count();
        foreach ($contractors as $contractor) {
            $comments = $this->users->getComments($contractor->id);
            $mean = (int)collect($comments)->avg('assessment');
            $contractor->comments = $comments;
            $contractor->mean = $mean;
        }
        $category = null;
        return view('site.pages.contractors.index', compact('category', 'contractors', 'contractorsCount'));
    }

    /**
     * Show contractors from category
     *
     * @param string $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function category(Request $request, string $params)
    {
        $paramsArray = explode('/', $params);
        $slug = end($paramsArray);
        $category = $this->categories->getBySlug($slug);
        if ($category) {
            if ($category->getAncestorsSlugs() !== $params) {
                return redirect(route('site.catalog.main', $category->getAncestorsSlugs()), 301);
            }
            $contractors = $category->getAllCompaniesFromDescendingCategories()->sortByDesc('created_at');
            $contractorsCount = $contractors->count();
            $contractors = PaginateCollection::paginateCollection($contractors, 5);
            foreach ($contractors as $contractor) {
                $comments = $this->users->getComments($contractor->id);
                $mean = (int)collect($comments)->avg('assessment');
                $contractor->comments = $comments;
                $contractor->mean = $mean;
            }

            return view('site.pages.contractors.index', compact('category', 'contractors', 'contractorsCount'));
        }
        abort(404);
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
        $comments = $this->users->getComments($contractor->id);
        $has_comment=false;
        $mean = 0;
        foreach ($comments as $comment_sum) {
            $mean += (int)$comment_sum->assessment;
        }
        if ($mean != 0) {
            $mean = $mean / count($comments);
        }

        abort_if(!$contractor, 404);

        if (auth()->user() && auth()->user()->hasRole('customer')) {
            if (!empty(Tender::where('owner_id', auth()->user()->id)->where('contractor_id', $contractor->id)->first())) {
                $has_comment = true;
            }
        }
        return view('site.pages.contractors.show', compact('contractor', 'portfolio', 'comments', 'mean', 'has_comment'));
    }

    public function addContractor(int $contractorId, int $tenderId)
    {
        $request = $this->tenders->addContractor($tenderId, $contractorId);
        $this->users->get($contractorId)->notify(new InviteRequest($request));
        return back()->with('success', 'Исполнитель добавлен в конкурс!');
    }

    public function addContractorForNonAuth(int $contractorId)
    {
        $user = $this->users->get($contractorId);
        $contractors = \Session::get('contractors', collect());
        if ($contractors->contains('id', $contractorId)) {
            return back();
        }
        $contractors->push([
            'id' => $contractorId,
            'name' => $user->getCommonTitle(),
            'image' => $user->getImage()
        ]);
        \Session::put('contractors', $contractors);
        return back();
    }

    public function deleteContractorFromSession(int $contractorId)
    {
        $contractors = \Session::get('contractors');
        if (!$contractors->contains('id', $contractorId)) {
            return back();
        }
        $contractors = $contractors->filter(function ($item) use ($contractorId) {
            return $item['id'] !== $contractorId;
        });
        if (count($contractors) === 0) {
            \Session::forget('contractors');
            \Session::save();
            return back();
        }
        \Session::put('contractors', $contractors);
        return back();
    }

    public function deleteAllContractorsFromSession()
    {
        \Session::forget('contractors');
        \Session::save();
        return back();
    }
}
