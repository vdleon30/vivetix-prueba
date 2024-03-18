<?php

namespace App\Providers;

use App\Http\Repositories\EventRepository;
use App\Http\Repositories\TicketRepository;
use App\Http\Services\EventServices;
use App\Http\Services\Services;
use App\Http\Repositories\Repository;
use App\Http\Services\TicketServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(Services::class, Repository::class);
        $this->app->bind(EventServices::class, EventRepository::class);
        $this->app->bind(TicketServices::class, TicketRepository::class);

    }
}
