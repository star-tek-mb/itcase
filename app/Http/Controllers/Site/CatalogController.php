<?php

namespace App\Http\Controllers\Site;

use App\Helpers\SlugHelper;
use App\Repositories\BlogPostRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    /**
     * Needs repository
     *
     * @var NeedTypeRepositoryInterface
    */
    private $needs;

    /**
     * Category repository
     *
     * @var HandbookCategoryRepositoryInterface
    */
    private $categories;

    /**
     * Company repository
     *
     * @var CompanyRepositoryInterface
    */
    private $companies;

    /**
     * Menu items repository
     *
     * @var MenuRepositoryInterface
     */
    private $menus;

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
     * Users repository
     *
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * Create a new controller instance
     *
     * @param NeedTypeRepositoryInterface $needsRepository
     * @param HandbookCategoryRepositoryInterface $categoriesRepository
     * @param CompanyRepositoryInterface $companyRepository
     * @param MenuRepositoryInterface $menuRepository
     * @param TenderRepositoryInterface $tenderRepository
     * @param BlogPostRepositoryInterface $blogPostRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        NeedTypeRepositoryInterface $needsRepository,
        HandbookCategoryRepositoryInterface $categoriesRepository,
        CompanyRepositoryInterface $companyRepository,
        MenuRepositoryInterface $menuRepository,
        TenderRepositoryInterface $tenderRepository,
        BlogPostRepositoryInterface $blogPostRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->needs = $needsRepository;
        $this->categories = $categoriesRepository;
        $this->companies = $companyRepository;
        $this->menus = $menuRepository;
        $this->tenders = $tenderRepository;
        $this->posts = $blogPostRepository;
        $this->users = $userRepository;
    }

    /**
     * Action for catalog
     *
     * @param Request $request
     * @param string $params
     * @return \Illuminate\Http\Response
    */
    public function catalog(Request $request, string $params)
    {
        if (preg_match('/[A-Z]/', $params)) {
            return redirect(route('site.catalog.main', strtolower($params)), 301);
        }
        abort_if(!SlugHelper::checkSlug($params), 404);
        $paramsArray = explode('/', trim($params, '/'));
        $slug = end($paramsArray);

        $menuItem = $this->menus->getBySlug($slug);
        if ($menuItem) {
            return $this->processMenuItem($request, $menuItem);
        }
        $category = $this->categories->getBySlug($slug);
        if ($category) {
            return $this->processCategory($request, $category);
        }
        $company = $this->companies->getBySlug($slug);
        if ($company) {
            return $this->processCompany($request, $company);
        }
        abort(404);
    }

    private function processNeed($need)
    {
        return view('site.pages.catalog.need', compact('need'));
    }

    private function processMenuItem(Request $request, $menuItem)
    {
        abort_if($menuItem->ru_slug !== $request->path(), 404);
        $companies = $menuItem->getCompanyFromCategories();
        if ($request->has('price')) {
            $orderingMethod = $request->get('price');
            if ($orderingMethod == 'asc') {
                $companies = $companies->sortBy('price');
            } elseif ($orderingMethod == 'desc') {
                $companies = $companies->sortBydesc('price');
            } else {
                abort(400);
            }
        }

        return view('site.pages.catalog.menuItem', compact('menuItem', 'companies'));
    }

    private function processCategory(Request $request, $category)
    {
        abort_if($category->getAncestorsSlugs() !== $request->path(), 404);
        $companies = $category->getAllCompaniesFromDescendingCategories();

        if ($request->has('price')) {
            $orderingMethod = $request->get('price');
            if ($orderingMethod == 'asc') {
                $companies = $companies->sortBy('price');
            } elseif ($orderingMethod == 'desc') {
                $companies = $companies->sortBydesc('price');
            } else {
                abort(400);
            }
        }

        $data = [
            'category' => $category,
            'companies' => $companies
        ];

        return view("site.templates.categories.$category->template", $data);
    }

    private function processCompany(Request $request, $company)
    {
        abort_if($company->getAncestorsSlugs() !== $request->path(), 404);
        return view('site.pages.catalog.company', compact('company'));
    }

    /**
     * Show concrete type of need
     *
     * @param string $needSlug
     * @return \Illuminate\Http\Response
    */
    public function need(string $needSlug)
    {
        if (is_numeric($needSlug)) {
            $id = intval($needSlug);
            $need = $this->needs->get($id);
            return redirect()->route('site.catalog.need', $need->ru_slug);
        }
        $need = $this->needs->getBySlug($needSlug);

        return view('site.pages.catalog.need', compact('need'));
    }

    /**
     * Show concrete category
     *
     * @param Request $request
     * @param string $categoryParams
     * @return \Illuminate\Http\Response
    */
    public function category(Request $request, string $categoryParams)
    {
        $categoriesArray = explode('/', trim($categoryParams, '/'));
        $slug = end($categoriesArray);
        if (is_numeric($slug)) {
            $id = intval($slug);
            $category = $this->categories->get($id);
            return redirect()->route('site.catalog.category', $category->ru_slug);
        }

        $category = $this->categories->getBySlug($slug);
        $descendantsCategories = $category->descendants;
        $companies = collect();
        $resultCompanies = [];
        $companies = $companies->merge($category->companies);
        foreach ($descendantsCategories as $descendantsCategory) {
            $companies = $companies->merge($descendantsCategory->companies);
        }
        if ($request->has('service')) {
            $serviceId = $request->get('service');
            foreach ($companies as $company) {
                if ($company->hasService($serviceId)) {
                    array_push($resultCompanies, $company);
                }
            }
        } else {
            $resultCompanies = $companies;
        }

        $data = [
            'category' => $category,
            'companies' => $resultCompanies
        ];

        return view('site.pages.catalog.companies', $data);
    }

    /**
     * Show company page
     *
     * @param string $companyParams
     * @return \Illuminate\Http\Response
    */
    public function company(string $companyParams)
    {
        $categoriesArray = explode('/', trim($companyParams, '/'));
        $slug = end($categoriesArray);
        if (is_numeric($slug)) {
            $id = intval($slug);
            $company = $this->companies->get($id);
            return redirect()->route('site.catalog.company', $company->ru_slug);
        }

        $company = $this->companies->getBySlug($slug);

        return view('site.pages.catalog.company', compact('company'));
    }

    /**
     * Seacrh companies or/and categories
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $category = $this->categories->search($query, $findOne = true);
        if ($category) {
            return redirect()->route('site.catalog.main', $category->getAncestorsSlugs());
        }
        $data = [];
        $categories = $this->categories->search($query);
        $companies = $this->companies->search($query);
        if ($categories->count() > 0  and $companies->count() == 0) {
            foreach ($categories as $category) {
                $companies = $companies->merge($category->companies);
            }
        }
        if ($companies->count() == 0 and $categories->count() == 1 and $categories[0]->hasCategories()) {
            $companies = $categories[0]->getAllCompaniesFromDescendingCategories();
        }
        $data['categories'] = $categories;
        $data['companies'] = $companies;
        $data['queryString'] = $query;
        return view('site.pages.catalog.search', $data);
    }
    public function ajax_search(Request $request)
    {
        $tenders = $this->tenders->TenderSearch($request);
        $result="";
        foreach ($tenders as $tender) {
            $result.='<a href="'.route('site.tenders.category', $tender->slug) .'">'.$tender->title.' </a>';
            $result.="<br>";
        }
        return $result;
        //return  $data;
    }
}
