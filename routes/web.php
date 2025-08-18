<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\IndexController as SiteController;
use App\Http\Controllers\Site\Blog\IndexController as BlogController;
use App\Http\Controllers\Site\Contact\IndexController as ContactController;
use App\Http\Controllers\Site\Portfolio\IndexController as PortfolioController;
use App\Http\Controllers\Site\Services\IndexController as ServicesController;
use App\Http\Controllers\Site\Subscribe\IndexController as SubscribeController;

use App\Http\Controllers\Site\Kvkk\IndexController as KvkkController;

//sitemap
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\BlogPost;
use App\Models\PortfolioPost;
use App\Models\Service;
use App\Models\About;





Route::get('/',[SiteController::class,'index'])->name('site.index');

Route::get('/yazi', [BlogController::class, 'index'])->name('site.blog');
Route::get('/yazi/{slug}', [BlogController::class, 'detail'])->name('site.blog.detail');

Route::get('/bize-ulasin', [ContactController::class, 'index'])->name('site.contact');
Route::post('/bize-ulasin/form-gonderildi', [ContactController::class, 'store'])->name('site.contact.store');

Route::get('/projeler', [PortfolioController::class, 'index'])->name('site.portfolio');
Route::get('/projeler/{slug}', [PortfolioController::class, 'detail'])->name('site.portfolio.detail');

Route::get('/hizmetler', [ServicesController::class, 'index'])->name('site.services');
Route::get('/hizmetler/{slug}', [ServicesController::class, 'detail'])->name('site.services.detail');

Route::get('/kvkk-metni', [KvkkController::class, 'index'])->name('site.kvkk');

Route::post('/haberdar-ol', [SubscribeController::class, 'store'])->name('subscribe.store');



Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();

    // Ana sayfa
    $sitemap->add(Url::create('/')
        ->setLastModificationDate(now())
        ->setChangeFrequency('daily')
        ->setPriority(1.0)
    );

    // Blog yazıları
    $blogPosts = BlogPost::all();
    foreach ($blogPosts as $post) {
        $sitemap->add(Url::create(route('site.blog.detail', $post->id)) // Eğer slug kullanıyorsan $post->slug olmalı
            ->setLastModificationDate($post->updated_at)
            ->setChangeFrequency('weekly')
            ->setPriority(0.8)
        );
    }

    // Portföy projeleri
    $portfolioPosts = PortfolioPost::all();
    foreach ($portfolioPosts as $portfolio) {
        $sitemap->add(Url::create(route('site.portfolio.detail', $portfolio->id))
            ->setLastModificationDate($portfolio->updated_at)
            ->setChangeFrequency('monthly')
            ->setPriority(0.7)
        );
    }

    // Hizmetler sayfası
    $services = Service::all();
    foreach ($services as $service) {
        $sitemap->add(Url::create(route('site.services.detail', $service->id))
            ->setLastModificationDate($service->updated_at)
            ->setChangeFrequency('monthly')
            ->setPriority(0.6)
        );
    }

 

    return $sitemap->toResponse(request());
});


route::get('/test', function () {
    return view('site.test');
});






