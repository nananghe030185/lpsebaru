<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\HtmlServiceProvider;

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
        //
        Gate::define('corporate', function(User $user){
            return $user->group_id === 6 || $user->group_id === 1;
        });
        Gate::define('member', function(User $user){
            return $user->group_id === 4 || $user->group_id === 5 ||$user->group_id === 1;
        });
        Gate::define('trial', function(User $user){
            return $user->group_id === 3;
        });
        Gate::define('nonmember', function(User $user){
            return $user->group_id === 2;
        });
        Gate::define('admin', function(User $user){
            return $user->group_id === 1;
        });
        Gate::define('gmt', function(User $user){
            return $user->group_id === 7;
        });
    }

}
