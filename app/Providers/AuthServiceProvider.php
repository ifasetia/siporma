<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Enums\RoleEnum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // SUPER ADMIN
        Gate::define('super-admin', function (User $user) {
            return $user->role === RoleEnum::SUPER_ADMIN;
        });

        // ADMIN (admin + super admin)
        Gate::define('admin', function (User $user) {
            return in_array($user->role, [
                RoleEnum::ADMIN,
                RoleEnum::SUPER_ADMIN,
            ]);
        });

        // INTERN
        Gate::define('intern', function (User $user) {
            return $user->role === RoleEnum::INTERN;
        });
    }
}
