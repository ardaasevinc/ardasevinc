<?php

namespace App\Http\Controllers\Site\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class IndexController extends Controller
{
    public function index()
{
    $page_title = 'Bize Ulaşın';
    return view('site.contact.index',compact('page_title'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
