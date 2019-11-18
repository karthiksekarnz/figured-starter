<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Tests\Traits\InteractsWithPassport;

class PostControllerTest extends TestCase
{
    use InteractsWithPassport;

    public function setUp(): void
    {
        parent::setUp();

        $this->createUserWithToken();
    }

    /**
     * Tests visitors can't view a post
     */
    public function testVisitorsCantViewPosts()
    {
        $this->json('GET', '/api/posts')
            ->assertStatus(401);
    }

    /**
     * Tests user can't manage a post
     */
    public function testUserCantManagePosts()
    {
        $this->user->assignRole('Reader');
        $this->be($this->user);

        $this->json('POST', '/api/post', [
            'title' => 'Demo',
            'content' => 'test'
        ], $this->headers)
        ->assertStatus(403);
    }

    /**
     * Test Admin can manage posts
     */
    public function testAdminCanManagePosts()
    {
        $this->user->assignRole('Admin');

        $this->be($this->user);

        $this->json('POST', '/api/post', [
            'title' => 'Demo',
            'content' => 'test'
        ], $this->headers)
        ->assertStatus(200);
    }

    public function tearDown(): void
    {
        User::destroy($this->user->id);

        parent::tearDown();
    }
}
