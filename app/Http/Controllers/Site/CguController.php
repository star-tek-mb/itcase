<?php

namespace App\Http\Controllers\Site;

use App\Repositories\CguCategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CguController extends Controller
{
    /**
     * CguCategory repository
     *
     * @var CguCategoryRepositoryInterface
    */
    private $categories;

    /**
     * Create a new controller instance
     *
     * @param CguCategoryRepositoryInterface $categoryRepository
     * @return void
    */
    public function __construct(CguCategoryRepositoryInterface $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }

    public function cguInfo()
    {
        $category = $this->categories->get(3);
        $files = $category->files()->paginate(36);
        $sites = $category->sites()->get();

        return view('site.pages.cgu.categories', compact('category', 'files', 'sites'));
    }

    public function cguAd()
    {
        $category = $this->categories->get(2);
        $files = $category->files()->paginate(36);
        $sites = $category->sites()->get();

        return view('site.pages.cgu.categories', compact(
            'category',
            'files',
            'sites'
        ));
    }

    public function cguCategory($id)
    {
        $category = $this->categories->get($id);
        $files = $category->files()->paginate(24);
        $sites = $category->sites()->get();

        return view('site.pages.cgu.category', compact(
            'category',
            'files',
            'sites'
        ));
    }
}
