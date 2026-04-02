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
        Gate::define('member', function(User $user){
            return $user->group_id === 2 || $user->group_id === 1;
        });
        Gate::define('admin', function(User $user){
            return $user->group_id === 1;
        });
    }
}
