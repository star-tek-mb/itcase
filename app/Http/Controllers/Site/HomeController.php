<?php

namespace App\Http\Controllers\Site;

use App\Repositories\BlogPostRepositoryInterface;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Howto;
use App\Models\PopularServices;
use App\Models\VacancyCategory;
use App\Models\Vacancy;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Tenders repository
     *
     * @var TenderRepositoryInterface
     */
    private $tenders;

    /**
     * Blog posts repository
     *
     * @var BlogPostRepositoryInterface
     */
    private $posts;

    /**
     * Category repository
     *
     * @var HandbookCategoryRepositoryInterface
     */
    private $categories;

    public function __construct(
        HandbookCategoryRepositoryInterface $categoriesRepository,
        TenderRepositoryInterface $tenderRepository,
        BlogPostRepositoryInterface $blogPostRepository
    )
    {
        $this->categories = $categoriesRepository;
        $this->tenders = $tenderRepository;
        $this->posts = $blogPostRepository;
    }

    /**
     * The home page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//        return view('site.pages.maintenance');
        // Check if url path has get parameters

//        if($request->isMethod("GET")){
//            dd($request->all());
//        }
        $search =null;
        $bolean = $request->has('search');
        if ($bolean == true) {
            $search = $request->search;
        }
//        if (array_key_exists('query', parse_url($request->fullUrl()))) {
//            return redirect(route('site.catalog.index'), 301);
//        }

//        dd('asd');

        $populars = PopularServices::take(4)->get();
        $parentCategories = $this->categories->all();

        $vacancyCategories = VacancyCategory::all();
        $cities = ['andijan', 'bukhara', 'jizzakh', 'qashqadaryo', 'navoiy', 'namangan', 'samarqand', 'surxondaryo', 'sirdaryo', 'tashkent', 'fergana', 'xorazm', 'karakalpakstan'];
        $vacanciesCount = [];
        foreach ($cities as $city) {
            $vacanciesCount[$city] = Vacancy::where('city', $city)->count();
        }
        $vacancies = Vacancy::latest()->take(5)->get();

        $tenders = $this->tenders->allOrderedByCreatedAt($withoutContractors = true)->take(5);
        $posts = $this->posts->allOrderByDesc()->take(3);
        $comments = Comment::latest()->limit(3)->whereNull('for_set')->get()->reverse();
        $howtos = Howto::all();
//        if($bolean == true){
//            dd($search);
//        }

        return view('site.pages.home', compact('parentCategories', 'search', 'tenders', 'posts', 'comments', 'populars', 'vacancies', 'vacancyCategories', 'vacanciesCount', 'howtos'));
    }

    public function page($params)
    {
        $locale = config('app.locale');
        $page = Page::where('slug->' . $locale, $params)->first();
        abort_if(!$page, 404);
        return view('site.pages.page', compact('page'));
    }
}
