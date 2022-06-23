<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        Gate::define('admin', function($user){
            return $user->role_id === User::ADMIN_ROLE_ID ? Response::allow() : Response::deny('You must be an admistrator.');
        });

        // Gate::define('notadmin', function($user){
        //     return $user->role_id === 2 ? Response::allow() : Response::deny('You cannot deactivate an administrator.');
        // });
    }
}
