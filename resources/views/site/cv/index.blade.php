@extends('layouts.site')

@section('content')
@php
    // Old verileri hazırlayalım (dinamik alanlar için güvenli defaultlar)
    $education    = old('education', [['school' => '', 'department' => '', 'year' => '']]);
    $experience   = old('experience', [['company' => '', 'position' => '', 'year' => '', 'desc' => '']]);
    $languages    = old('languages', [['name' => '', 'level' => '']]);
    $certificates = old('certificates', [['name' => '', 'year' => '']]);
@endphp

<!-- hero -->
<div class="mil-hero-1 mil-sm-hero mil-up" id="top">
    <div class="container mil-hero-main mil-relative mil-aic">
        <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
            <div class="mil-text-pad"></div>
            <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                <li><a href="{{ route('site.index') }}">Anasayfa</a></li>
                <li><a href="#.">{{ $page_title ?? 'CV Oluştur' }}</a></li>
            </ul>
            <div class="mil-word-frame">
                <h1 class="mil-display2 mil-rubber">CV <span class="mil-a2">OLUŞTUR</span></h1>
                <div class="mil-s-4">
                    <img src="{{ asset('site/assets/img/shapes/4.png') }}" alt="shape">
                </div>
            </div>
        </div>
        <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
            <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
            <div class="mil-s-3"><img src="{{ asset('site/assets/img/shapes/3.png') }}" alt="shape"></div>
        </div>
    </div>
</div>
<!-- hero end -->

<!-- CV Form -->
<div class="container">
    <div class="mil-half-container mil-up">
        <div class="mil-g-m1 mil-p-160-160">
            <p class="mt-5 m-2">
                Bu formu doldurarak profesyonel bir CV oluşturabilirsiniz. A4 PDF çıktısını tek tıkla indirebilirsiniz.
                Verileriniz yalnızca CV üretimi için kullanılır ve üçüncü kişilerle paylaşılmaz. Fotoğraf opsiyoneldir;
                yalnızca PDF oluşturulurken işlenir, ardından sistemden silinir.
            </p>

            @if (session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('site.cv.submit') }}" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row mil-aic">
                    <!-- Kişisel Bilgiler -->
                    <div class="col-md-6 mil-mb30 mil-up">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Ad Soyad" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mil-mb30 mil-up">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="E-Posta" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mil-mb30 mil-up">
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Telefon" required>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mil-mb30 mil-up">
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" placeholder="Doğum Tarihi">
                        @error('birth_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Fotoğraf -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <div id="drop-area" class="file-drop-area">
                            <input type="file" name="photo" id="photoInput" accept="image/*" hidden>
                            <div class="file-drop-content">
                                <div class="upload-icon" aria-hidden="true">
                                    <!-- Bootstrap Icons yoksa bile sorun çıkmasın diye fallback -->
                                    <span style="font-size:40px;line-height:1;"><img
                                        src="{{ asset('site/assets/img/photo-upload.svg') }}"
                                        class="img-fluid rounded-top"
                                        alt=""
                                        height="100px"
                                        opacity="0.5"
                                        
                                    />
                                    </span>
                                </div>
                                <p class="upload-text">Fotoğrafınızı buraya sürükleyin<br>veya seçmek için tıklayın</p>
                                <span id="file-name" class="file-name">Henüz dosya seçilmedi</span>
                            </div>
                        </div>
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Kariyer Hedefi -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <textarea name="career_goal" placeholder="Kariyer Hedefiniz (Kendinizi kısaca tanıtın)">{{ old('career_goal') }}</textarea>
                        @error('career_goal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Eğitim -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <label class="mil-text-sm">Eğitim Bilgileri</label>
                        <div id="education-wrapper" data-next-index="{{ count($education) }}">
                            @foreach ($education as $i => $edu)
                                <div class="row mil-mb20">
                                    <div class="col-md-4">
                                        <input type="text" name="education[{{ $i }}][school]" value="{{ $edu['school'] ?? '' }}" placeholder="Okul Adı">
                                        @error("education.$i.school") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="education[{{ $i }}][department]" value="{{ $edu['department'] ?? '' }}" placeholder="Bölüm/Program">
                                        @error("education.$i.department") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="education[{{ $i }}][year]" value="{{ $edu['year'] ?? '' }}" placeholder="Yıl (2018-2022)">
                                        @error("education.$i.year") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-education">
                            + Eğitim Ekle
                        </button>
                      
                    </div>

                    <!-- İş Deneyimi -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <label class="mil-text-sm">İş Deneyimleri</label>
                        <div id="experience-wrapper" data-next-index="{{ count($experience) }}">
                            @foreach ($experience as $i => $exp)
                                <div class="row mil-mb20">
                                    <div class="col-md-4">
                                        <input type="text" name="experience[{{ $i }}][company]" value="{{ $exp['company'] ?? '' }}" placeholder="Şirket Adı">
                                        @error("experience.$i.company") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="experience[{{ $i }}][position]" value="{{ $exp['position'] ?? '' }}" placeholder="Pozisyon">
                                        @error("experience.$i.position") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="experience[{{ $i }}][year]" value="{{ $exp['year'] ?? '' }}" placeholder="Yıl (2021-2023)">
                                        @error("experience.$i.year") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-12 mil-mt10">
                                        <textarea name="experience[{{ $i }}][desc]" placeholder="Görevler / Açıklama">{{ $exp['desc'] ?? '' }}</textarea>
                                        @error("experience.$i.desc") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-experience">
                            + İş Deneyimi Ekle
                        </button>
                    </div>

                    <!-- Yabancı Diller -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <label class="mil-text-sm">Yabancı Diller</label>
                        <div id="language-wrapper" data-next-index="{{ count($languages) }}">
                            @foreach ($languages as $i => $lang)
                                <div class="row mil-mb20">
                                    <div class="col-md-6">
                                        <input type="text" name="languages[{{ $i }}][name]" value="{{ $lang['name'] ?? '' }}" placeholder="Dil (örn: İngilizce)">
                                        @error("languages.$i.name") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="languages[{{ $i }}][level]" value="{{ $lang['level'] ?? '' }}" placeholder="Seviye (örn: İyi)">
                                        @error("languages.$i.level") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-language">
                            + Dil Ekle
                        </button>
                    </div>

                    <!-- Sertifikalar -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <label class="mil-text-sm">Sertifikalar</label>
                        <div id="certificate-wrapper" data-next-index="{{ count($certificates) }}">
                            @foreach ($certificates as $i => $cert)
                                <div class="row mil-mb20">
                                    <div class="col-md-8">
                                        <input type="text" name="certificates[{{ $i }}][name]" value="{{ $cert['name'] ?? '' }}" placeholder="Sertifika/Kurs Adı">
                                        @error("certificates.$i.name") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="certificates[{{ $i }}][year]" value="{{ $cert['year'] ?? '' }}" placeholder="Yıl">
                                        @error("certificates.$i.year") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-certificate">
                            + Sertifika Ekle
                        </button>
                    </div>

                    <!-- Hobiler -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <textarea name="hobbies" placeholder="Hobiler / İlgi Alanları">{{ old('hobbies') }}</textarea>
                        @error('hobbies') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Referanslar -->
                    <div class="col-md-12 mil-mb30 mil-up">
                        <textarea name="references" placeholder="Referanslar (İsim, Pozisyon, İletişim)">{{ old('references') }}</textarea>
                        @error('references') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- KVKK -->
                    <div class="col-md-12 mil-mb30 mil-up d-flex justify-content-between">
                        <div class="form-check d-flex justify-content-start ">
                            <input class="form-check-input me-2" type="checkbox" id="kvkk_onay" name="kvkk_onay"
                                   value="1" style="height: 24px; width:24px;" {{ old('kvkk_onay') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="kvkk_onay">
                                <a href="{{ route('site.kvkk') }}" target="_blank">KVKK Aydınlatma Metni</a>'ni okudum, kabul ediyorum. <br>
                                <small class="text-muted">*Verileriniz yalnızca CV’nizi oluşturmak için kullanılacaktır.</small>
                            </label>
                        </div>
                        @error('kvkk_onay') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Bilgilendirme -->
                    <div class="col-md-6 mil-mb30">
                        <p class="mil-text-sm mil-up">
                            *Verileriniz yalnızca CV’nizi oluşturmak için kullanılacaktır.
                        </p>
                    </div>

                    <!-- Buton -->
                    <div class="col-md-6 mil-mb30 mil-768-mb0 mil-jce mil-768-jcc mil-up">
                        <button type="submit" class="mil-btn mil-a2 mil-c-gone">PDF Çıktı Al</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- CV Form End -->

{{-- ===== Styles (sade, çakışmasın) ===== --}}
<style>
    .file-drop-area {
        border: 2px dashed #ccc; border-radius: 10px; padding: 40px;
        text-align: center; cursor: pointer; transition: all .3s ease; background: transparent;
    }
    .file-drop-area:hover { border-color: transparent; background: #f0f0f0; }
    .file-drop-area.dragover { border-color: #007bff; background: #eaf4ff; }
    .upload-icon { margin-bottom: 10px; }
    .upload-text { font-size: 14px; color: #666; margin: 5px 0; }
    .file-name { display: block; margin-top: 10px; font-size: 13px; color: #333; font-weight: 600; }
</style>

{{-- ===== Scripts ===== --}}
<script>
// 1) Ready helper: DOM hazırsa hemen çalıştır; değilse olayı bir kez dinle.
function onReady(fn) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn, { once: true });
    } else { fn(); }
}

// 2) KVKK checkbox init
function initKvkk() {
    const kvkkCheckbox = document.getElementById("kvkk_onay");
    if (!kvkkCheckbox) return;
    kvkkCheckbox.addEventListener("change", function () {
        if (this.checked) window.open("{{ route('site.kvkk') }}", "_blank");
    });
}

// 3) Drop area init
function initDropArea() {
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("photoInput");
    const fileName  = document.getElementById("file-name");
    if (!dropArea || !fileInput || !fileName) return;

    dropArea.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", function () {
        fileName.textContent = fileInput.files?.[0]?.name || "Henüz dosya seçilmedi";
    });

    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault(); dropArea.classList.add("dragover");
    });
    dropArea.addEventListener("dragleave", () => dropArea.classList.remove("dragover"));
    dropArea.addEventListener("drop", (e) => {
        e.preventDefault(); dropArea.classList.remove("dragover");
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileName.textContent = e.dataTransfer.files[0].name;
        }
    });
}

// 4) Dinamik alanlar init (server-side next-index ile güvenli)
function initDynamicFields() {
    const $eduWrap  = document.getElementById("education-wrapper");
    const $expWrap  = document.getElementById("experience-wrapper");
    const $langWrap = document.getElementById("language-wrapper");
    const $certWrap = document.getElementById("certificate-wrapper");

    let educationIndex  = parseInt($eduWrap?.dataset.nextIndex || '1', 10);
    let experienceIndex = parseInt($expWrap?.dataset.nextIndex || '1', 10);
    let languageIndex   = parseInt($langWrap?.dataset.nextIndex || '1', 10);
    let certificateIndex= parseInt($certWrap?.dataset.nextIndex || '1', 10);

    const btnEdu  = document.getElementById("add-education");
    const btnExp  = document.getElementById("add-experience");
    const btnLang = document.getElementById("add-language");
    const btnCert = document.getElementById("add-certificate");

    if (btnEdu && $eduWrap) {
        btnEdu.addEventListener("click", function () {
            const i = educationIndex++;
            const html = `
                <div class="row mil-mb20">
                    <div class="col-md-4"><input type="text" name="education[${i}][school]" placeholder="Okul Adı"></div>
                    <div class="col-md-4"><input type="text" name="education[${i}][department]" placeholder="Bölüm/Program"></div>
                    <div class="col-md-4"><input type="text" name="education[${i}][year]" placeholder="Yıl (2018-2022)"></div>
                </div>`;
            $eduWrap.insertAdjacentHTML("beforeend", html);
        });
    }

    if (btnExp && $expWrap) {
        btnExp.addEventListener("click", function () {
            const i = experienceIndex++;
            const html = `
                <div class="row mil-mb20">
                    <div class="col-md-4"><input type="text" name="experience[${i}][company]" placeholder="Şirket Adı"></div>
                    <div class="col-md-4"><input type="text" name="experience[${i}][position]" placeholder="Pozisyon"></div>
                    <div class="col-md-4"><input type="text" name="experience[${i}][year]" placeholder="Yıl (2021-2023)"></div>
                    <div class="col-md-12 mil-mt10"><textarea name="experience[${i}][desc]" placeholder="Görevler / Açıklama"></textarea></div>
                </div>`;
            $expWrap.insertAdjacentHTML("beforeend", html);
        });
    }

    if (btnLang && $langWrap) {
        btnLang.addEventListener("click", function () {
            const i = languageIndex++;
            const html = `
                <div class="row mil-mb20">
                    <div class="col-md-6"><input type="text" name="languages[${i}][name]" placeholder="Dil (örn: İngilizce)"></div>
                    <div class="col-md-6"><input type="text" name="languages[${i}][level]" placeholder="Seviye (örn: İyi)"></div>
                </div>`;
            $langWrap.insertAdjacentHTML("beforeend", html);
        });
    }

    if (btnCert && $certWrap) {
        btnCert.addEventListener("click", function () {
            const i = certificateIndex++;
            const html = `
                <div class="row mil-mb20">
                    <div class="col-md-8"><input type="text" name="certificates[${i}][name]" placeholder="Sertifika/Kurs Adı"></div>
                    <div class="col-md-4"><input type="text" name="certificates[${i}][year]" placeholder="Yıl"></div>
                </div>`;
            $certWrap.insertAdjacentHTML("beforeend", html);
        });
    }
}

// 5) Tüm init’leri tek noktadan çağır
onReady(() => {
    initKvkk();
    initDropArea();
    initDynamicFields();
});
</script>
@endsection
