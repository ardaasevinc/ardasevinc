<?php


namespace App\Http\Controllers\Site\Portfolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PortfolioPost;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Projelerimiz';
        $portfolio = PortfolioPost::where('is_published', 1)->paginate(10);
        
        return view('site.portfolio.index', compact('page_title', 'portfolio'));
    }

    public function detail($slug)
    {
        $page_title = 'Proje Detayı';

        // Slug ile projeyi bul ve ilişkili media'yı getir
        $portfolio = PortfolioPost::with('media')
            ->where('slug', $slug)
            ->firstOrFail();

        // Bir sonrakini slug'a göre değil, ID sırasına göre bulmak istiyorsan:
        $nextportfolio = PortfolioPost::where('id', '>', $portfolio->id)
        ->where('is_published', 1)
        ->orderBy('id', 'asc')
        ->first();

        return view('site.portfolio.detail', compact('page_title', 'portfolio', 'nextportfolio'));
    }

}

