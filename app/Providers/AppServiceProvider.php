<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('user.layouts.layout',function($view){
            $cates = Category::where('parent_id', 0)->get();
            $sub_cates = Category::where('parent_id', '!=', 0)->get();
            $view->with([
                'cates' => $cates,
                'sub_cates' => $sub_cates
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
