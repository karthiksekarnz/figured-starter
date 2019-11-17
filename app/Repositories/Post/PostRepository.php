<?php


namespace App\Repositories\Post;

use App\Models\Post;
use Rinvex\Repository\Repositories\EloquentRepository;

class PostRepository extends EloquentRepository implements PostRepositoryContract
{
    protected $model = Post::class;
}
