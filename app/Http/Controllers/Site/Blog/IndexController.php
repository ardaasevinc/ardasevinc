<?php

namespace App\Http\Controllers\Site\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class IndexController extends Controller
{
    public function index(){
        $page_title = 'Bloglar';
        $blog =BlogPost::paginate(6);
        return view('site.blog.index',compact('page_title','blog'));
    }

public function detail($slug)
{
    $page_title = 'Blog Detayı';
    $blog = BlogPost::with('media')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('site.blog.detail', compact('page_title', 'blog'));
}


}
