<?php

namespace Innoscripta\Domain\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Innoscripta\Domain\Auth\Repositories\Contracts\UserRepository;
use Innoscripta\Domain\Auth\Repositories\Eloquent\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
