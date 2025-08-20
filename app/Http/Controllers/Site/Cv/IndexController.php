<?php

namespace App\Http\Controllers\Site\Cv;

use App\Http\Controllers\Controller;
use App\Models\CvSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'CV Oluştur';
        $page_description = 'CV Oluşturma sayfası.';
        return view('site.cv.index', compact('page_title', 'page_description'));
    }

    public function submit(Request $request)
    {
        // ---- Kurallar
        $rules = [
            // Basit alanlar
            'name' => ['bail', 'required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'email:rfc,dns', 'max:255'],
            'phone' => ['bail', 'required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/'],
            'birth_date' => ['nullable', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:min_width=200,min_height=200'],
            'career_goal' => ['nullable', 'string', 'max:2000'],
            'hobbies' => ['nullable', 'string', 'max:1000'],
            'references' => ['nullable', 'string', 'max:2000'],

            // Repeater kökleri
            'education' => ['nullable', 'array'],
            'experience' => ['nullable', 'array'],
            'languages' => ['nullable', 'array'],
            'certificates' => ['nullable', 'array'],

            // Education items
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.department' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:25', 'regex:/^(\d{4})(\s*-\s*\d{4})?$/'],

            // Experience items
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.position' => ['nullable', 'string', 'max:255'],
            'experience.*.year' => ['nullable', 'string', 'max:25', 'regex:/^(\d{4})(\s*-\s*\d{4})?$/'],
            'experience.*.desc' => ['nullable', 'string', 'max:1000'],

            // Language items
            'languages.*.name' => ['nullable', 'string', 'max:100'],
            'languages.*.level' => ['nullable', 'string', 'max:100'],

            // Certificates items
            'certificates.*.name' => ['nullable', 'string', 'max:255'],
            'certificates.*.year' => ['nullable', 'string', 'max:25', 'regex:/^\d{4}$/'],
        ];

        // ---- Özel mesajlar (özet)
        $messages = [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'phone.regex' => 'Telefon numarası yalnızca rakam, boşluk ve - ( ) + içerebilir.',
        ];

        // ---- Alan adları (kısa)
        $attributes = [
            'name' => 'Ad Soyad',
            'email' => 'E-posta',
            'phone' => 'Telefon',
        ];

        $validated = $request->validate($rules, $messages, $attributes);

        // Repeater’lar null gelirse boş dizi yap
        foreach (['education', 'experience', 'languages', 'certificates'] as $field) {
            $validated[$field] = $validated[$field] ?? [];
        }

        // FOTOĞRAF: uploads diski -> public/uploads
        // config/filesystems.php içinde 'uploads' root'u public_path('uploads') olmalı.
        if ($request->hasFile('photo')) {
            // Sonuç: "cv/photos/abc.jpg" (uploads köküne göre relatif)
            $stored = $request->file('photo')->store('cv/photos', 'uploads');
            // DB’ye public kökten göre kaydedelim: "uploads/cv/photos/abc.jpg"
            $validated['photo_path'] = 'uploads/' . ltrim($stored, '/');
        }

        $cv = CvSubmission::create($validated);

        return redirect()
            ->route('site.cv.download', $cv->id)
            ->with('success', '🎉 CV başarıyla oluşturuldu! PDF indiriliyor...');
    }

    public function download(CvSubmission $cv)
    {
        // Blade içinde kullanman için "file://" mutlak yolları hazırlayalım:
        $logoPublicRel = 'site/assets/logo.png'; // public/site/assets/logo.png
        $photoPublicRel = $cv->photo_path ?: null; // "uploads/..." şeklinde

        $logoFileUrl = $this->toFileUrl(public_path($logoPublicRel));
        $photoFileUrl = $photoPublicRel ? $this->toFileUrl(public_path($photoPublicRel)) : null;

        // DomPDF seçenekleri: yerelden okuma, html5 parser, dpi, default font
        $pdf = Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'dpi' => 96,
            'defaultFont' => 'Montserrat',
            'chroot' => public_path(), // güvenli kök
        ])
            ->loadView('site.cv.template', [
                'cv' => $cv,
                // Blade’te <img src="{{ $logoFileUrl }}"> gibi kullan
                'logoFileUrl' => $logoFileUrl,
                'photoFileUrl' => $photoFileUrl,
            ])
            ->setPaper('a4', 'portrait');

        $fileName = 'cv-' . Str::slug($cv->name) . '.pdf';
        return $pdf->download($fileName);
    }

    public function show()
    {
        $page_title = 'CV Şablonu';
        $page_description = 'CV şablonunu görüntüleme sayfası.';
        $cv = CvSubmission::latest()->first();

        $logoPublicRel = 'site/assets/logo.png';
        $photoPublicRel = $cv?->photo_path;

        $logoFileUrl = $this->toFileUrl(public_path($logoPublicRel));
        $photoFileUrl = $photoPublicRel ? $this->toFileUrl(public_path($photoPublicRel)) : null;

        return view('site.cv.template', compact('page_title', 'page_description', 'cv', 'logoFileUrl', 'photoFileUrl'));
    }

    /** PDF için mutlak file:// yolu üretir (Dompdf en stabil bunu sever) */
    private function toFileUrl(string $absPath): ?string
    {
        return is_file($absPath) ? ('file://' . $absPath) : null;
    }
}
