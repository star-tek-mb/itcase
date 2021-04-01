<?php

namespace App\Repositories;

use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    /**
     * @param $post_id
     * @return mixed
     */
    public function get($post_id)
    {
        return BlogPost::find($post_id);
    }

    /**
     *
     * @return mixed
     */
    public function all()
    {
        return BlogPost::all();
    }

    /**
     *
     * @param int
     */
    public function delete($post_id)
    {
        $post = $this->get($post_id);
        $post->delete();
    }


    /**
     * @param $post_id
     * @param object $post_data
     * @return mixed
     */
    public function update($post_id, object $post_data)
    {
        $post = $this->get($post_id);
        $post->update($post_data->all());
        $post->uploadImage($post_data->file('image'));
        // $post->removeImage($post_data->file('image'));
        return $post;
    }

    /**
     * Store a category
     *
     * @param object $blog_data
     * @return mixed
     */
    public function store(object $blog_data)
    {
        $post = BlogPost::create($blog_data->all());
        $post->uploadImage($blog_data->file('image'));
        $post->generateSlug();

        return $post;
    }

    /**
     * @inheritDoc
     */
    public function getBySlug(string $slug)
    {
        return BlogPost::where('ru_slug', $slug)->first();
    }

    /**
     * @inheritDoc
     */
    public function allOrderByDesc()
    {
        return BlogPost::orderBy('created_at', 'desc')->get();
    }
}
