<?php


namespace App\Http\Controllers\Site\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe;

class IndexController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // E-posta adresini kontrol et
        $subscribe = Subscribe::firstOrCreate(
            ['email' => $request->email], // Aranacak email
            [] // Yeni bir kayıt oluşturulursa eklenmesi gereken alanlar
        );

        if (!$subscribe->wasRecentlyCreated) {
            // Eğer zaten kayıtlıysa
            return redirect()->back()->with('warning', 'Bu e-posta adresini daha önce kaydetmişiz.');
        }

        return redirect()->back()->with('success', 'E-posta adresinizi başarıyla kaydettiniz.');
    }
}
