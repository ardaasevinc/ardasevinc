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
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:20',
            'birth_date'  => 'nullable|date',
            'photo'       => 'nullable|image|max:2048',
            'career_goal' => 'nullable|string|max:2000',
            'hobbies'     => 'nullable|string|max:1000',
            'references'  => 'nullable|string|max:2000',

            'education'    => 'nullable|array',
            'experience'   => 'nullable|array',
            'languages'    => 'nullable|array',
            'certificates' => 'nullable|array',
        ]);

        $data = $validated;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('cv/photos', 'public');
        }

        // Repeater alanları boşsa array garantile
        foreach (['education', 'experience', 'languages', 'certificates'] as $field) {
            $data[$field] = $data[$field] ?? [];
        }

        $cv = CvSubmission::create($data);

        return redirect()
            ->route('site.cv.download', $cv->id)
            ->with('success', 'CV başarıyla oluşturuldu!');
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
        $cv =CvSubmission::first();
        return view('site.cv.template', compact('page_title', 'page_description','cv'));
    }
}
