<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\FaqRepositoryInterface;
use App\Repositories\HandbookCategoryRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\NeedTypeRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Handbook Category repository
     *
     * @var HandbookCategoryRepositoryInterface
    */
    protected $companyCategories;

    /**
     * Company repository
     *
     * @var CompanyRepositoryInterface
    */
    protected $companies;

    /**
     * User repository
     *
     * @var UserRepositoryInterface
    */
    protected $users;

    /**
     * Repository for types of needs
     *
     * @var NeedTypeRepositoryInterface
     */
    private $needTypesRepository;

    /**
     * Repository of services
     *
     * @var ServiceRepositoryInterface
    */
    private $services;

    /**
     * @var FaqRepositoryInterface
     */
    private $faqRepository;

    /**
     * Create a new instance
     *
     * @param HandbookCategoryRepositoryInterface $companyCategoryRepository
     * @param CompanyRepositoryInterface $companyRepository
     * @param UserRepositoryInterface $userRepository
     * @param NeedTypeRepositoryInterface $needTypesRepository
     * @param ServiceRepositoryInterface $servicesRepository
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        HandbookCategoryRepositoryInterface $companyCategoryRepository,
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository,
        NeedTypeRepositoryInterface $needTypesRepository,
        ServiceRepositoryInterface $servicesRepository,
        FaqRepositoryInterface $faqRepository
    )
    {
        $this->companyCategories = $companyCategoryRepository;
        $this->companies = $companyRepository;
        $this->users = $userRepository;
        $this->needTypesRepository = $needTypesRepository;
        $this->services = $servicesRepository;
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('searchQuery')) {
            $companies = $this->companies->search($request->get('searchQuery'));
            $paginate = false;
        } else {
            $companies = $this->companies->all(10);
            $paginate = true;
        }

        $data = [
            'companies' => $companies,
            'paginate' => $paginate
        ];

        return view('admin.pages.companies.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => $this->companyCategories->getTree(),
            'users' => $this->users->all(),
            'needs' => $this->needTypesRepository->all(),
            'services' => $this->services->all(),
            'faqs' => $this->faqRepository->all()
        ];

        return view('admin.pages.companies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ru_title' => 'required|max:255',
        ]);
        $company = $this->companies->create($request);
        $categoryId = $request->get('category_id');
        if ($categoryId != 0) {
            $position = $this->companyCategories->get($categoryId)->companies()->count();
            $company->position = $position;
            $company->save();
        }
        $companyMeta = $company->createMetaInformation();
        auth()->user()->addHistoryItem('company.create', $companyMeta);

        if ($request->has('saveQuit')) {
            return redirect()->route('admin.companies.index');
        }
        return redirect()->route('admin.companies.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = $this->companies->get($id);
        $categories = $this->companyCategories->getTree();

        $data = [
            'company' => $company,
            'categories' => $categories,
            'users' => $this->users->all(),
            'needs' => $this->needTypesRepository->all(),
            'services' => $this->services->all(),
            'faqs' => $this->faqRepository->all()
        ];

        return view('admin.pages.companies.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ru_title' => 'required|max:255',
        ]);
        $company = $this->companies->update($id, $request);

        $companyMeta = $company->createMetaInformation();
        auth()->user()->addHistoryItem('company.update', $companyMeta);

        return redirect()->route('admin.companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = $this->companies->get($id);
        $companyMeta = $company->createMetaInformation();
        $this->companies->delete($id);
        auth()->user()->addHistoryItem('company.delete', $companyMeta);

        return redirect()->route('admin.companies.index');
    }

    /**
     * Change position for company
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
    */
    public function changePosition(Request $request)
    {
        $companyId = $request->get('id');
        $position = $request->get('position');
        if ($this->companies->setPosition($companyId, $position)) {
            return Response::create('', 200);
        } else {
            return Response::create('', 400);
        }
    }

    /**
     * Remove image for company
     *
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function removeImage(int $id)
    {
        $company = $this->companies->get($id);
        $company->removeImages();

        return redirect()->back();
    }
}
