<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //identificar cada tipo de user
        //Miguel Silva
        Gate::define('employee', function (User $user): bool {
            return $user->type === 'E';
        });

        Gate::define('admin', function (User $user): bool {
            return $user->type === 'A';
        });

        Gate::define('customer', function (User $user): bool {
            return $user->type === 'C';
        });

        Gate::guessPolicyNamesUsing(function ($modelClass): string {
            return 'App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
