<?php

namespace App\Http\Controllers\Site\Cv;

use App\Http\Controllers\Controller;
use App\Models\CvSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'name'        => ['bail', 'required', 'string', 'max:255'],
            'email'       => ['bail', 'required', 'email:rfc,dns', 'max:255'],
            'phone'       => ['bail', 'required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/'],
            'birth_date'  => ['nullable', 'date'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:min_width=200,min_height=200'],
            'career_goal' => ['nullable', 'string', 'max:2000'],
            'hobbies'     => ['nullable', 'string', 'max:1000'],
            'references'  => ['nullable', 'string', 'max:2000'],

            // KVKK
            'kvkk_onay'   => ['accepted'],

            // Repeater kökleri
            'education'   => ['nullable', 'array'],
            'experience'  => ['nullable', 'array'],
            'languages'   => ['nullable', 'array'],
            'certificates'=> ['nullable', 'array'],

            // Education items
            'education.*.school'     => ['nullable', 'string', 'max:255'],
            'education.*.department' => ['nullable', 'string', 'max:255'],
            'education.*.year'       => ['nullable', 'string', 'max:25', 'regex:/^(\d{4})(\s*-\s*\d{4})?$/'],

            // Experience items
            'experience.*.company'   => ['nullable', 'string', 'max:255'],
            'experience.*.position'  => ['nullable', 'string', 'max:255'],
            'experience.*.year'      => ['nullable', 'string', 'max:25', 'regex:/^(\d{4})(\s*-\s*\d{4})?$/'],
            'experience.*.desc'      => ['nullable', 'string', 'max:1000'],

            // Language items
            'languages.*.name'       => ['nullable', 'string', 'max:100'],
            'languages.*.level'      => ['nullable', 'string', 'max:100'],

            // Certificates items
            'certificates.*.name'    => ['nullable', 'string', 'max:255'],
            'certificates.*.year'    => ['nullable', 'string', 'max:25', 'regex:/^\d{4}$/'],
        ];

        // ---- Özel mesajlar
        $messages = [
            'name.required'       => 'Ad Soyad alanı zorunludur.',
            'email.required'      => 'E-posta alanı zorunludur.',
            'email.email'         => 'Geçerli bir e-posta adresi girin.',
            'phone.required'      => 'Telefon alanı zorunludur.',
            'phone.regex'         => 'Telefon numarası yalnızca rakam, boşluk ve - ( ) + içerebilir.',
            'kvkk_onay.accepted'  => '📌 KVKK Aydınlatma Metni onayı olmadan devam edemezsiniz.',
        ];

        // ---- Alan adları (kısa)
        $attributes = [
            'name'       => 'Ad Soyad',
            'email'      => 'E-posta',
            'phone'      => 'Telefon',
            'kvkk_onay'  => 'KVKK Onayı',
        ];

        $validated = $request->validate($rules, $messages, $attributes);

        // Repeater’lar null gelirse boş dizi yap
        foreach (['education', 'experience', 'languages', 'certificates'] as $field) {
            $validated[$field] = $validated[$field] ?? [];
        }

        // FOTOĞRAF: uploads diski -> public/uploads
        if ($request->hasFile('photo')) {
            $stored = $request->file('photo')->store('cv/photos', 'uploads');
            $validated['photo_path'] = 'uploads/' . ltrim($stored, '/');
        }

        // KVKK değerini boolean olarak set et (checkbox işaretlenmemişse 0)
        $validated['kvkk_onay'] = $request->has('kvkk_onay') ? 1 : 0;

        $cv = CvSubmission::create($validated);

        return redirect()
            ->route('site.cv.download', $cv->id)
            ->with('success', '🎉 CV başarıyla oluşturuldu! PDF indiriliyor...');
    }

    public function download(CvSubmission $cv)
    {
        $logoPublicRel = 'site/assets/logo.png';
        $photoPublicRel = $cv->photo_path ?: null;

        $logoFileUrl = $this->toFileUrl(public_path($logoPublicRel));
        $photoFileUrl = $photoPublicRel ? $this->toFileUrl(public_path($photoPublicRel)) : null;

        $pdf = Pdf::setOptions([
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
            'dpi'                  => 96,
            'defaultFont'          => 'Montserrat',
            'chroot'               => public_path(),
        ])
            ->loadView('site.cv.template', [
                'cv'           => $cv,
                'logoFileUrl'  => $logoFileUrl,
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

    /** PDF için mutlak file:// yolu üretir */
    private function toFileUrl(string $absPath): ?string
    {
        return is_file($absPath) ? ('file://' . $absPath) : null;
    }
}
