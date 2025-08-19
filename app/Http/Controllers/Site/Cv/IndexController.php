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
            // 2018-2022 veya tek yıl 2022 gibi kabul et
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

        // ---- Özel mesajlar (Türkçe)
        $messages = [
            // Basit alanlar
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'name.max' => 'Ad Soyad en fazla :max karakter olabilir.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'phone.regex' => 'Telefon numarası yalnızca rakam, boşluk ve - ( ) + içerebilir.',
            'phone.max' => 'Telefon en fazla :max karakter olabilir.',
            'birth_date.date' => 'Doğum tarihi geçerli bir tarih olmalıdır.',

            'photo.image' => 'Yüklenen dosya bir görsel olmalıdır.',
            'photo.mimes' => 'Fotoğraf yalnızca: :values formatlarında olmalıdır.',
            'photo.max' => 'Fotoğraf boyutu en fazla :max KB olabilir.',
            'photo.dimensions' => 'Fotoğraf en az 200x200 piksel olmalıdır.',

            'career_goal.max' => 'Kariyer hedefi en fazla :max karakter olabilir.',
            'hobbies.max' => 'Hobiler en fazla :max karakter olabilir.',
            'references.max' => 'Referanslar en fazla :max karakter olabilir.',

            // Repeater kökleri
            'education.array' => 'Eğitim bilgileri geçersiz biçimde gönderildi.',
            'experience.array' => 'İş deneyimleri geçersiz biçimde gönderildi.',
            'languages.array' => 'Yabancı diller geçersiz biçimde gönderildi.',
            'certificates.array' => 'Sertifikalar geçersiz biçimde gönderildi.',

            // Education items
            'education.*.school.max' => 'Okul adı en fazla :max karakter olabilir.',
            'education.*.department.max' => 'Bölüm/Program en fazla :max karakter olabilir.',
            'education.*.year.regex' => 'Yıl alanı "2020" veya "2018-2022" formatında olmalıdır.',
            'education.*.year.max' => 'Yıl en fazla :max karakter olabilir.',

            // Experience items
            'experience.*.company.max' => 'Şirket adı en fazla :max karakter olabilir.',
            'experience.*.position.max' => 'Pozisyon en fazla :max karakter olabilir.',
            'experience.*.year.regex' => 'Yıl alanı "2020" veya "2018-2022" formatında olmalıdır.',
            'experience.*.year.max' => 'Yıl en fazla :max karakter olabilir.',
            'experience.*.desc.max' => 'Görev/Açıklama en fazla :max karakter olabilir.',

            // Language items
            'languages.*.name.max' => 'Dil adı en fazla :max karakter olabilir.',
            'languages.*.level.max' => 'Dil seviyesi en fazla :max karakter olabilir.',

            // Certificates items
            'certificates.*.name.max' => 'Sertifika/Kurs adı en fazla :max karakter olabilir.',
            'certificates.*.year.regex' => 'Sertifika yılı dört haneli olmalıdır (örn. 2023).',
            'certificates.*.year.max' => 'Sertifika yılı en fazla :max karakter olabilir.',
        ];

        // ---- Alan adları (güzel görünen)
        $attributes = [
            'name' => 'Ad Soyad',
            'email' => 'E-posta',
            'phone' => 'Telefon',
            'birth_date' => 'Doğum Tarihi',
            'photo' => 'Fotoğraf',
            'career_goal' => 'Kariyer Hedefi',
            'hobbies' => 'Hobiler',
            'references' => 'Referanslar',

            // Dinamikler
            'education.*.school' => 'Okul Adı',
            'education.*.department' => 'Bölüm/Program',
            'education.*.year' => 'Yıl',

            'experience.*.company' => 'Şirket Adı',
            'experience.*.position' => 'Pozisyon',
            'experience.*.year' => 'Yıl',
            'experience.*.desc' => 'Görevler / Açıklama',

            'languages.*.name' => 'Dil',
            'languages.*.level' => 'Seviye',

            'certificates.*.name' => 'Sertifika/Kurs Adı',
            'certificates.*.year' => 'Sertifika Yılı',
        ];

        // Doğrulama (hata olursa otomatik back()->withErrors()->withInput())
        $validated = $request->validate($rules, $messages, $attributes);

        // Boş/undefined repeaterları diziye çevir (null gelirse patlamasın)
        foreach (['education', 'experience', 'languages', 'certificates'] as $field) {
            $validated[$field] = $validated[$field] ?? [];
        }

        // Fotoğraf yükleme
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('cv/photos', 'public');
        }

        $cv = CvSubmission::create($validated);

        return redirect()
            ->route('site.cv.download', $cv->id)
            ->with('success', '🎉 CV başarıyla oluşturuldu! PDF indiriliyor...');
    }

    public function download(CvSubmission $cv)
    {
        $pdf = Pdf::loadView('site.cv.template', compact('cv'))
            ->setPaper('A4', 'portrait');

        $fileName = 'cv-' . Str::slug($cv->name) . '.pdf';

        return $pdf->download($fileName);
    }

    public function show()
    {
        $page_title = 'CV Şablonu';
        $page_description = 'CV şablonunu görüntüleme sayfası.';
        $cv = CvSubmission::first();
        return view('site.cv.template', compact('page_title', 'page_description', 'cv'));
    }
}
