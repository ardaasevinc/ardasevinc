<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\About;
use App\Models\Icon;
use App\Models\Service;
use App\Models\BlogPost;
use App\Models\Experience;


class IndexController extends Controller
{
    public function index(){
    $hero = Hero::where('is_published', 1)->first();
    $page_title = 'Anasayfa';
    $about =About::Where('is_published',1)->first();
    $iconbox =Icon::Where('is_published',1)->paginate(3);
    $service = Service::Where('is_published',1)->paginate(3);
    $blog = BlogPost::Where('is_published',1)->paginate(5);
    $exp = Experience::paginate(3);
    
    return view('site.index', compact('page_title', 'hero','about','iconbox','service','blog','exp'));
}

}
