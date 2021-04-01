<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepositoryInterface;
use App\Repositories\BlogPostRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogPostController extends Controller
{
    /**
     * @var BlogPostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var BlogCategoryRepositoryInterface
     */
    protected $categoryRepository;


    public function __construct(
        BlogPostRepositoryInterface $blogPostRepository,
        BlogCategoryRepositoryInterface $categoryRepository
    )
    {
        $this->postRepository = $blogPostRepository;
        $this->categoryRepository = $categoryRepository;
    }


    public function index()
    {
        $data = [
            'posts' => $this->postRepository->all()
        ];

        return view('admin.pages.blog.posts.index', $data);
    }


    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('admin.pages.blog.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'ru_title' => 'required|unique:blog_posts|max:255',
            'ru_short_content' => 'nullable',
            'en_short_content' => 'nullable',
            'uz_short_content' => 'nullable',
            'ru_content'=>'nullable',
            'uz_content'=>'nullable',
            'en_content'=>'nullable',
            'image' => 'nullable|image'
        ]);

        $post = $this->postRepository->store($request);

        if ($request->has('save')) {
            return redirect()->route('admin.blogposts.create');
        } else {
            return redirect()->route('admin.blogposts.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $data = [
            'post' => $this->postRepository->get($id),
            'categories' => $this->categoryRepository->all()
        ];

        return view('admin.pages.blog.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ru_title' => 'required|max:255',
        ]);

        $post = $this->postRepository->update($id, $request);

        if ($request->has('save')) {
            return redirect()->route('admin.blogposts.edit', $post->id);
        } else {
            return redirect()->route('admin.blogposts.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);

        return redirect()->route('admin.blogposts.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function removeImage($id)
    {
        $post = $this->postRepository->get($id);
        $post->removeImage();

        return redirect()->route('admin.blogposts.edit', $post->id);
    }
}
