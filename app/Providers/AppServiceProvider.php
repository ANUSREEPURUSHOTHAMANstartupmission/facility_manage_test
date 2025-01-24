<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Blade::if('perms', function($exp){
            if($exp){
                $req = explode('|', $exp);
                $permissions = array_column(auth()->user()->role->permissions->toArray(),"name");

                return !empty(array_intersect($req, $permissions));
            }
            else{
                return true;
            }
        });

        Paginator::useBootstrap();
    }
}
