@extends('layouts.site')

@section('content')
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
                    <h1 class="mil-display2 mil-rubber">BİZE <span class="mil-a2">ULAŞIN</span></h1>
                    <div class="mil-s-4"><img src="{{ asset('site/assets/img/shapes/4.png') }}" alt="shape"></div>
                </div>
            </div>
            <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                <div class="mil-s-3"><img src="{{ asset('site/assets/img/shapes/3.png') }}" alt="shape"></div>
            </div>
        </div>
    </div>
    <div class="mil-p-0-100">
        <div class="container">
            <div class="row mil-jcc">
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-tac mil-mb60">
                        <i class="fal fa-mobile mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Ara</h4>
                        {{-- Tıklanabilir ve formatlı telefon numarası --}}
                        @if($settings?->phone)
                            <p class="mil-stylized mil-m1 mil-mb15 mil-up">
                                <a href="tel:{{ $settings->phone }}" class="mil-c-gone">
                                    {{ $settings->phone_formatted ?? $settings->phone }}
                                </a>
                            </p>
                        @endif
                        <p class="mil-stylized mil-m1 mil-up">{{ $settings?->work_time }}</p>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-mb60">
                        <i class="fal fa-comment-alt-edit mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Yaz</h4>
                        @if($settings?->email)
                            <p class="mil-m1 mil-mb15 mil-up">
                                <a href="mailto:{{ $settings->email }}" class="mil-c-gone">{{ $settings->email }}</a>
                            </p>
                        @endif
                        <p class="mil-m1 mil-up">{{ $settings?->slogan }}</p>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-tac mil-mb60">
                        <i class="fal fa-map-marker-alt mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Ziyaret Et</h4>
                        <p class="mil-stylized mil-m1 mil-mb15 mil-up">
                            {!! nl2br(e($settings?->address)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="mil-half-container mil-up">
            <div class="mil-text-box mil-g-m1 mil-p-160-160">
                <h2 class="mil-display3 mil-rubber mil-mb60 mil-m4 mil-up">BİZE <span class="mil-a1">ULAŞIN.</span></h2>
                
                @if(session('success'))
                    <div class="mil-mb30 mil-up">
                        <p class="mil-text-sm mil-a1">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('site.contact.store') }}">
                    @csrf
                    <div class="row mil-aic">
                        <div class="col-md-6 mil-mb30 mil-up">
                            <input type="text" name="name" placeholder="ADINIZ NEDİR?" required>
                        </div>
                        <div class="col-md-6 mil-mb30 mil-up">
                            <input type="email" name="email" placeholder="E-POSTA ADRESİNİZ" required>
                        </div>
                        <div class="col-md-12 mil-mb30 mil-up">
                            <textarea name="message" placeholder="PROJENİZ HAKKINDA BİLGİ VERİNİZ." required></textarea>
                        </div>
                        <div class="col-md-6 mil-mb30">
                            <p class="mil-text-sm mil-up">*Kişisel bilgilerinizin üçüncü taraflarla paylaşılmayacağına söz veriyoruz.</p>
                        </div>
                        <div class="col-md-6 mil-mb30 mil-768-mb0 mil-jce mil-768-jcc mil-up">
                            <button type="submit" class="mil-btn mil-a2 mil-c-gone">Gönder</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="mil-image-box mil-c-gone">
                <div class="mil-image-frame">
                    {{-- Harita Iframe (Panelden girilen iframe kodunu basar) --}}
                    @if($settings?->map_iframe)
                        {!! $settings->map_iframe !!}
                    @else
                        {{-- Harita kodu yoksa varsayılan boş bir görsel veya placeholder --}}
                        <img src="{{ asset('uploads/' . (App\Models\Portfolio::where('is_published', 1)->first()?->img1)) }}" alt="İletişim">
                    @endif
                    <div class="mil-overlay"></div>
                </div>
            </div>
        </div>
        <div class="row mil-aic mil-jcb mil-no-g">
            <div class="col-lg-6">
                <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
            </div>
            <div class="col-lg-6 mil-992-gone">
                <div class="mil-text-pad">
                    <p class="mil-text-sm mil-up">Gönder butonuna tıklayarak,
                        <br><a href="#" class="mil-text-link mil-a2 mil-c-gone">kişisel verilerin işlenme kurallarını</a>
                        kabul etmiş olursunuz.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endsection