<?php

namespace App\Services\Post;

interface PostServiceContract
{
    /**
     * Find a post by slug
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug);

    /**
     * Fetch posts
     *
     * @param int $items
     * @return mixed
     */
    public function fetch(int $items = 5);

    /**
     * Creates a post
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a post
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a post
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
