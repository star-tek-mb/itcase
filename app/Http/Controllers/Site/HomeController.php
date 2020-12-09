<?php

namespace App\Http\Controllers\Site;

use App\Repositories\BlogPostRepositoryInterface;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments;

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

    public function __construct(HandbookCategoryRepositoryInterface $categoriesRepository,
                                TenderRepositoryInterface $tenderRepository,
                                BlogPostRepositoryInterface $blogPostRepository)
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
        // Check if url path has get parameters
        if (array_key_exists('query', parse_url($request->fullUrl())))
            return redirect(route('site.catalog.index'), 301);
        $parentCategories = $this->categories->all();
        $tenders = $this->tenders->allOrderedByCreatedAt($withoutContractors = true)->take(3);
        $posts = $this->posts->allOrderByDesc()->take(3);
        $comments = Comments::latest()->limit(3)->whereNull('for_set')->get()->reverse();;
        return view('site.pages.home', compact('parentCategories', 'tenders', 'posts', 'comments'));
    }
}
