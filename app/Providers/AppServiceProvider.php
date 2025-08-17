<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\BlogPost;
use Illuminate\Support\Facades\View;

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
       
        $settings = Setting::pluck('value', 'key')->toArray();
        View::share('settings', $settings);

        $blog_menu = BlogPost::Where('is_published',1)->paginate(5);
        View::share('blog_menu',$blog_menu);
    }
}
