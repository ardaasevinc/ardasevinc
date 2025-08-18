<?php

namespace App\Http\Controllers\Site\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Icon;
use App\Models\Service;

class IndexController extends Controller
{
    public function index(){
        $page_title = 'Hizmetlerimiz';
        $service= Service::get();
        return view ('site.services.index', compact('page_title','service'));
    }

   public function detail($slug)
{
    $page_title = 'Hizmet Detayı';
    $service = Service::where('slug', $slug)->firstOrFail();
    $iconbox = Icon::where('is_published', 1)->paginate(3);

    return view('site.services.detail', compact('page_title', 'iconbox', 'service'));
}

}
