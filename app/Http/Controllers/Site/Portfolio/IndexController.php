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

    public function detail($id)
    {
        $page_title = 'Proje Detayı';

        // PortfolioPost'u ID ile bul ve ilişkili media dosyalarını getir
        $portfolio = PortfolioPost::with('media')->findOrFail($id);
        
    $nextportfolio = PortfolioPost::where('id', '>', $id)
        ->where('is_published', 1)
        ->orderBy('id', 'asc')
        ->first();

        return view('site.portfolio.detail', compact('page_title', 'portfolio','nextportfolio'));
    }
}

