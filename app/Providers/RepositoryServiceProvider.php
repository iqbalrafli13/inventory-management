<?php

namespace App\Providers;

use App\Repositories\Contracts\KaryawanRepositoryInterface;
use App\Repositories\Eloquent\KaryawanRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KaryawanRepositoryInterface::class, KaryawanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
