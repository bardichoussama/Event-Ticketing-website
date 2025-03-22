<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICategoryRepository;
use App\Interfaces\IEventRepository;
use App\Interfaces\IReservationRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EventRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IEventRepository::class, EventRepository::class);
        $this->app->bind(IReservationRepository::class, ReservationRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
