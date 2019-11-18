<?php

namespace App\Services\Post;

use Illuminate\Support\Str;
use App\Repositories\Post\PostRepositoryContract;

class PostService implements PostServiceContract
{
    /**
     * @var PostRepositoryContract
     */
    private $postRepository;

    /**
     * PostService constructor.
     *
     * @param PostRepositoryContract $postRepository
     */
    public function __construct(PostRepositoryContract $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Fetch posts
     *
     * @param int $items
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function fetch(int $items = 5)
    {
        return $this->postRepository->paginate($items);
    }

    /**
     * Find a post by slug
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug)
    {
        return $this->postRepository->findBy('slug', $slug);
    }

    /**
     * Creates a post
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $data['slug'] = $this->createUniqueSlug($data['title']);

        return $this->postRepository->store(null, $data);
    }

    /**
     * Update a post
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    /**
     * Delete a post
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    /**
     * Create a unique slug from post Ptitle
     *
     * @param string $title
     * @return string
     */
    private function createUniqueSlug(string $title)
    {
        $slug = Str::slug($title);
        $similarPosts = $this->postRepository->where('slug', 'like', $slug.'%');

        if ($similarPosts->count() == 1) {
            return $slug.'-2';
        }

        if ($similarPosts->count() == 2) {
            return $slug.'-'.uniqid();
        }

        return $slug;
    }
}
