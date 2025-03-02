<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ImpCategories;
use App\Models\Navigation;
use App\Models\News;
use App\Models\websiteInfo;
use DateTime;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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

        $web_info = websiteInfo::first();

        $date = new DateTime();

        // get previous motnth
        $date = $date->modify('-5 month');

        /// format month
        $date = $date->format('Y-m-d');
        $_news = News::where('status' ,1)->where('updated_at' ,'>=' ,$date)->orderBy('updated_at' ,'desc')->limit(2)->get(['id' ,'title' ,'category_id','updated_at']);

        $_cats = Navigation::all(['category_id']);
        $categories_all = Category::all(['id' ,'name']);

        View::share([
            'webInfo' => $web_info ,
            '_news' => $_news,
            '_cats' => $_cats,
            'categories_all' => $categories_all
        ]);

        Paginator::useBootstrap();

    }
}
