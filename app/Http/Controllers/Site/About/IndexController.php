<?php

namespace App\Http\Controllers\Site\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
class IndexController extends Controller
{
    public function index(){
        $page_title = "Hakkımızda";
        $about=About::where('is_published',1)->first();
        return view ('site.about.index',compact('page_title','about'));
    }
}
