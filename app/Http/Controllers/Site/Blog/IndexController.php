<?php

namespace App\Http\Controllers\Site\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class IndexController extends Controller
{
    public function index(){
        $page_title = 'Bloglar';
        $blog =BlogPost::paginate(5);
        return view('site.blog.index',compact('page_title','blog'));
    }

   public function detail($id){
    $page_title = 'Blog Detayı';
    $blog = BlogPost::with('media')->findOrFail($id);
    
    return view('site.blog.detail', compact('page_title', 'blog'));
}

}
