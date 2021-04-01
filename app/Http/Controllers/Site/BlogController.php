<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlogCategoryRepositoryInterface;
use App\Repositories\BlogPostRepositoryInterface;
use App\Helpers\SlugHelper;

class BlogController extends Controller
{
    /**
     * @var BlogCategoryRepositoryInterface
     */
    private $blogCategories;

    /**
     * @var BlogPostRepositoryInterface
     */
    private $blogPosts;

    public function __construct(
        BlogCategoryRepositoryInterface $blogCategoryRepository,
        BlogPostRepositoryInterface $blogPostRepository
    )
    {
        $this->blogCategories = $blogCategoryRepository;
        $this->blogPosts = $blogPostRepository;
    }

    /**
     * Display a home page of the blog
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->blogCategories->all();
        $posts = $this->blogPosts->allOrderByDesc();
        return view('site.pages.blog.index', compact('categories', 'posts'));
    }

    /**
     * Display a category or post of the blog
     *
     * @param Request $request
     * @param string $params
     * @return void
     */
    public function blog(Request $request, string $params)
    {
        if (preg_match('/[A-Z]/', $params)) {
            return redirect(route('site.blog.main', strtolower($params)), 301);
        }
        $paramsArray = explode('/', trim($params, '/'));
        $slug = end($paramsArray);

        $blogCategory = $this->blogCategories->getBySlug($slug);
        if ($blogCategory) {
            if ($blogCategory->ru_slug !== $params) {
                return redirect(route('site.blog.main', $blogCategory->ru_slug), 301);
            }
            return $this->processBlogCategory($request, $blogCategory);
        }
        $blogPost = $this->blogPosts->getBySlug($slug);
        if ($blogPost) {
            if ($blogPost->getAncestorsSlugs() !== $params) {
                return redirect(route('site.blog.main', $blogPost->getAncestorsSlugs()), 301);
            }
            return $this->processBlogPost($request, $blogPost);
        } else {
            abort(404);
        }
    }

    private function processBlogCategory(Request $request, \App\Models\BlogCategory $category)
    {
        $categories = $this->blogCategories->all();
        return view('site.pages.blog.category', compact('category', 'categories'));
    }

    private function processBlogPost(Request $request, \App\Models\BlogPost $post)
    {
        $categories = $this->blogCategories->all();
        return view('site.pages.blog.post', compact('post', 'categories'));
    }
}
