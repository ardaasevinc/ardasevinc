<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {

        $page_title = 'Kvkk Metni';
        return view('site.kvkk.index',compact('page_title'));
    }

    
}
