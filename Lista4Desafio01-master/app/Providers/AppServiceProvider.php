<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Domain\Posts\PostEntity;
use App\Policies\PostPolicy;
use App\Domain\Comments\CommentEntity;
use App\Policies\CommentPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Domain\Users\UserRepositoryInterface::class,
    \App\Infrastructure\Eloquent\UserEloquentRepository::class);

    $this->app->bind(
    \App\Domain\Posts\PostRepositoryInterface::class, 
    \App\Infrastructure\Eloquent\PostEloquentRepository::class);

    $this->app->bind(
        \App\Domain\Comments\CommentRepositoryInterface::class,
        \App\Infrastructure\Eloquent\CommentEloquentRepository::class
);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(PostEntity::class, PostPolicy::class);
        Gate::policy(CommentEntity::class, CommentPolicy::class);
    }
}
