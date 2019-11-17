<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Posts\PostCreateRequest;
use App\Http\Requests\Posts\PostUpdateRequest;
use App\Services\Post\PostServiceContract;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * @var PostServiceContract
     */
    private $postService;

    /**
     * PostController constructor.
     *
     * @param ResponseFactory $response
     * @param PostServiceContract $postService
     */
    public function __construct(ResponseFactory $response, PostServiceContract $postService)
    {
        $this->response = $response;
        $this->postService = $postService;

        parent::__construct($response);
    }

    /**
     * Get all posts
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->response->json($this->postService->fetch());
    }

    /**
     * Get a post by slug
     *
     * @param $slug
     * @return JsonResponse
     */
    public function get($slug)
    {
        return $this->response->json([
            'data' => $this->postService->findBySlug($slug)
        ]);
    }

    /**
     * Create a post
     *
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function create(PostCreateRequest $request)
    {
        try {
            $post = $this->postService->create([
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);

            return $this->response->json([
                'post' => $post
            ]);
        } catch (\Exception $e) {
            return $this->response->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update a post
     *
     * @param PostUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        try {
            $post = $this->postService->update($id, [
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);

            return $this->response->json([
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return $this->response->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('manage-posts');

        $this->postService->delete($id);

        return $this->response->json([
            'message' => 'Post deleted'
        ]);
    }
}
