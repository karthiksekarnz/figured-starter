<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryContract;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceContract;
use App\Services\Post\PostServiceContract;
use App\Services\Post\PostService;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            'user' => User::class
        ]);

        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
        $this->app->bind(PostServiceContract::class, PostService::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(AuthServiceContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
