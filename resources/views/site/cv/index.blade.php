@extends('layouts.site')

@section('content')
    <!-- hero -->
    <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
        <div class="container mil-hero-main mil-relative mil-aic">
            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                <div class="mil-text-pad"></div>
                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                    <li>
                        <a href="{{ route('site.index') }}">Anasayfa</a>
                    </li>
                    <li>
                        <a href="#.">{{ $page_title }}</a>
                    </li>
                </ul>
                <div class="mil-word-frame">
                    <h1 class="mil-display2 mil-rubber">CV <span class="mil-a2">OLUŞTUR</span></h1>
                    <p class="mt-5 m-2">Bu formu doldurarak profesyonel bir CV oluşturabilirsiniz. Sizden istenen bilgileri
                        eksiksiz
                        girdikten sonra, tek tıkla A4 formatında PDF çıktısını indirmeniz mümkün olacaktır.

                        CV’niz yalnızca sizin için hazırlanır ve bilgileriniz hiçbir şekilde üçüncü kişilerle paylaşılmaz.
                        Fotoğraf eklemek zorunlu değildir; eklerseniz yalnızca PDF oluşturulurken kullanılır ve sonrasında
                        sistemden silinir.

                        Eksik bırakılan alanlar CV’nizde boş olarak görünebilir. Daha etkili bir CV için tüm alanları
                        doldurmanız tavsiye edilir.</p>
                    <div class="mil-s-4"><img src="{{ asset('site/assets/img/shapes/4.png') }}" alt="shape"></div>
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

                @if(session('success'))
                    <p class="success-message">{{ session('success') }}</p>
                @endif

                <form method="POST" action="{{ route('site.cv.submit') }}" enctype="multipart/form-data">
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
                                    <div class="upload-icon">
                                        <i class="bi bi-cloud-upload" style="font-size: 40px;"></i>
                                    </div>
                                    <p class="upload-text">Fotoğrafınızı buraya sürükleyin<br>veya seçmek için tıklayın</p>
                                    <span id="file-name" class="file-name">Henüz dosya seçilmedi</span>
                                </div>
                            </div>
                            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Kariyer Hedefi -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <textarea name="career_goal"
                                placeholder="Kariyer Hedefiniz (Kendinizi kısaca tanıtın)">{{ old('career_goal') }}</textarea>
                            @error('career_goal') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Eğitim -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <label class="mil-text-sm">Eğitim Bilgileri</label>
                            <div id="education-wrapper">
                                @php
                                    $education = old('education', [['school' => '', 'department' => '', 'year' => '']]);
                                @endphp
                                @foreach($education as $i => $edu)
                                    <div class="row mil-mb20">
                                        <div class="col-md-4">
                                            <input type="text" name="education[{{ $i }}][school]" value="{{ $edu['school'] }}"
                                                placeholder="Okul Adı">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="education[{{ $i }}][department]"
                                                value="{{ $edu['department'] }}" placeholder="Bölüm/Program">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="education[{{ $i }}][year]" value="{{ $edu['year'] }}"
                                                placeholder="Yıl (2018-2022)">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-education">
                                <i class="bi bi-plus-circle"></i> Eğitim Ekle
                            </button>
                        </div>

                        <!-- İş Deneyimi -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <label class="mil-text-sm">İş Deneyimleri</label>
                            <div id="experience-wrapper">
                                @php
                                    $experience = old('experience', [['company' => '', 'position' => '', 'year' => '', 'desc' => '']]);
                                @endphp
                                @foreach($experience as $i => $exp)
                                    <div class="row mil-mb20">
                                        <div class="col-md-4">
                                            <input type="text" name="experience[{{ $i }}][company]"
                                                value="{{ $exp['company'] }}" placeholder="Şirket Adı">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="experience[{{ $i }}][position]"
                                                value="{{ $exp['position'] }}" placeholder="Pozisyon">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="experience[{{ $i }}][year]" value="{{ $exp['year'] }}"
                                                placeholder="Yıl (2021-2023)">
                                        </div>
                                        <div class="col-md-12 mil-mt10">
                                            <textarea name="experience[{{ $i }}][desc]"
                                                placeholder="Görevler / Açıklama">{{ $exp['desc'] }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-experience">
                                <i class="bi bi-plus-circle"></i> İş Deneyimi Ekle
                            </button>
                        </div>

                        <!-- Yabancı Diller -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <label class="mil-text-sm">Yabancı Diller</label>
                            <div id="language-wrapper">
                                @php
                                    $languages = old('languages', [['name' => '', 'level' => '']]);
                                @endphp
                                @foreach($languages as $i => $lang)
                                    <div class="row mil-mb20">
                                        <div class="col-md-6">
                                            <input type="text" name="languages[{{ $i }}][name]" value="{{ $lang['name'] }}"
                                                placeholder="Dil (örn: İngilizce)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="languages[{{ $i }}][level]" value="{{ $lang['level'] }}"
                                                placeholder="Seviye (örn: İyi)">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-language">
                                <i class="bi bi-plus-circle"></i> Dil Ekle
                            </button>
                        </div>

                        <!-- Sertifikalar -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <label class="mil-text-sm">Sertifikalar</label>
                            <div id="certificate-wrapper">
                                @php
                                    $certificates = old('certificates', [['name' => '', 'year' => '']]);
                                @endphp
                                @foreach($certificates as $i => $cert)
                                    <div class="row mil-mb20">
                                        <div class="col-md-8">
                                            <input type="text" name="certificates[{{ $i }}][name]" value="{{ $cert['name'] }}"
                                                placeholder="Sertifika/Kurs Adı">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="certificates[{{ $i }}][year]" value="{{ $cert['year'] }}"
                                                placeholder="Yıl">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="mil-btn mil-btn-border mil-c-gone" id="add-certificate">
                                <i class="bi bi-plus-circle"></i> Sertifika Ekle
                            </button>
                        </div>

                        <!-- Hobiler -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <textarea name="hobbies" placeholder="Hobiler / İlgi Alanları">{{ old('hobbies') }}</textarea>
                        </div>

                        <!-- Referanslar -->
                        <div class="col-md-12 mil-mb30 mil-up">
                            <textarea name="references"
                                placeholder="Referanslar (İsim, Pozisyon, İletişim)">{{ old('references') }}</textarea>
                        </div>

                        <!-- Bilgilendirme -->
                        <div class="col-md-6 mil-mb30">
                            <p class="mil-text-sm mil-up">
                                *Verileriniz yalnızca CV’nizi oluşturmak için kullanılacaktır.
                            </p>
                        </div>

                        <!-- Buton -->
                        <div class="col-md-6 mil-mb30 mil-768-mb0 mil-jce mil-768-jcc mil-up">
                            <button type="submit" class="mil-btn mil-a2 mil-c-gone">
                                PDF Çıktı Al
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- CV Form End -->


    <!-- Dinamik Alanlar JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let educationIndex = 1;
            let experienceIndex = 1;
            let languageIndex = 1;
            let certificateIndex = 1;

            // Eğitim
            document.getElementById("add-education").addEventListener("click", function () {
                let wrapper = document.getElementById("education-wrapper");
                let html = `
                <div class="row mil-mb20">
                    <div class="col-md-4">
                        <input type="text" name="education[${educationIndex}][school]" placeholder="Okul Adı">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="education[${educationIndex}][department]" placeholder="Bölüm/Program">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="education[${educationIndex}][year]" placeholder="Yıl (2018-2022)">
                    </div>
                </div>`;
                wrapper.insertAdjacentHTML("beforeend", html);
                educationIndex++;
            });

            // İş Deneyimi
            document.getElementById("add-experience").addEventListener("click", function () {
                let wrapper = document.getElementById("experience-wrapper");
                let html = `
                <div class="row mil-mb20">
                    <div class="col-md-4">
                        <input type="text" name="experience[${experienceIndex}][company]" placeholder="Şirket Adı">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="experience[${experienceIndex}][position]" placeholder="Pozisyon">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="experience[${experienceIndex}][year]" placeholder="Yıl (2021-2023)">
                    </div>
                    <div class="col-md-12 mil-mt10">
                        <textarea name="experience[${experienceIndex}][desc]" placeholder="Görevler / Açıklama"></textarea>
                    </div>
                </div>`;
                wrapper.insertAdjacentHTML("beforeend", html);
                experienceIndex++;
            });

            // Yabancı Dil
            document.getElementById("add-language").addEventListener("click", function () {
                let wrapper = document.getElementById("language-wrapper");
                let html = `
                <div class="row mil-mb20">
                    <div class="col-md-6">
                        <input type="text" name="languages[${languageIndex}][name]" placeholder="Dil (örn: İngilizce)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="languages[${languageIndex}][level]" placeholder="Seviye (örn: İyi)">
                    </div>
                </div>`;
                wrapper.insertAdjacentHTML("beforeend", html);
                languageIndex++;
            });

            // Sertifikalar
            document.getElementById("add-certificate").addEventListener("click", function () {
                let wrapper = document.getElementById("certificate-wrapper");
                let html = `
                <div class="row mil-mb20">
                    <div class="col-md-8">
                        <input type="text" name="certificates[${certificateIndex}][name]" placeholder="Sertifika/Kurs Adı">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="certificates[${certificateIndex}][year]" placeholder="Yıl">
                    </div>
                </div>`;
                wrapper.insertAdjacentHTML("beforeend", html);
                certificateIndex++;
            });
        });
    </script>


    <style>
        .file-drop-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: transparent;
        }

        .file-drop-area:hover {
            border-color: transparent;
            background-color: #f0f0f0;
        }

        .file-drop-area.dragover {
            border-color: #007bff;
            background-color: #eaf4ff;
        }

        .upload-icon {
            margin-bottom: 10px;
            color: #007bff;
        }

        .upload-text {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .file-name {
            display: block;
            margin-top: 10px;
            font-size: 13px;
            color: #333;
            font-weight: bold;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropArea = document.getElementById("drop-area");
            const fileInput = document.getElementById("photoInput");
            const fileName = document.getElementById("file-name");

            // Alanı tıklayınca dosya seç
            dropArea.addEventListener("click", () => fileInput.click());

            // Dosya seçildiğinde göster
            fileInput.addEventListener("change", function () {
                if (fileInput.files.length > 0) {
                    fileName.textContent = fileInput.files[0].name;
                } else {
                    fileName.textContent = "Henüz dosya seçilmedi";
                }
            });

            // Sürükleme olayları
            dropArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropArea.classList.add("dragover");
            });

            dropArea.addEventListener("dragleave", () => {
                dropArea.classList.remove("dragover");
            });

            dropArea.addEventListener("drop", (e) => {
                e.preventDefault();
                dropArea.classList.remove("dragover");
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    fileName.textContent = e.dataTransfer.files[0].name;
                }
            });
        });
    </script>


@endsection