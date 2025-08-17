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
    <!-- hero end -->

    <!-- contact info -->
    <div class="mil-p-0-100">
        <div class="container">
            <div class="row mil-jcc">
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-tac mil-mb60">
                        <i class="fal fa-mobile mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Ara</h4>
                        <p class="mil-stylized mil-m1 mil-mb15 mil-up">Ofis: +90 (532) 637 99 44</p>
                        <p class="mil-stylized mil-m1 mil-up">{{strip_tags($settings['CONTACT_PHONE'])}}</p>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-mb60">
                        <i class="fal fa-comment-alt-edit mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Yaz</h4>
                        <p class="mil-m1 mil-mb15 mil-up"><a
                                href="mailto:info@ardasevinc.com.tr">info@ardasevinc.com.tr</a></p>
                        <p class="mil-m1 mil-up"><a
                                href="mailto:{{strip_tags($settings['CONTACT_EMAIL'])}}">{{strip_tags($settings['CONTACT_EMAIL'])}}</a></p>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-tac mil-mb60">
                        <i class="fal fa-map-marker-alt mil-mb30 mil-up"></i>
                        <h4 class="mil-head4 mil-mb30 mil-up">Ziyaret Et</h4>
                        <p class="mil-stylized mil-m1 mil-mb15 mil-up">{{strip_tags($settings['CONTACT_ADDRESS'])}}</p>
                        <p class="mil-stylized mil-m1 mil-up"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- contact info end -->

    <!-- contact form -->
    <div class="container">
        <div class="mil-half-container mil-up">
            <div class="mil-text-box mil-g-m1 mil-p-160-160">
                <h2 class="mil-display3 mil-rubber mil-mb60 mil-m4 mil-up">BİZE <span class="mil-a1">ULAŞIN.</span></h2>
                @if(session('success'))
                    <p class="success-message">{{ session('success') }}</p>
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
                            <p class="mil-text-sm mil-up">*Kişisel bilgilerinizin üçüncü taraflarla paylaşılmayacağına söz
                                veriyoruz.
                            </p>
                        </div>
                        <div class="col-md-6 mil-mb30 mil-768-mb0 mil-jce mil-768-jcc mil-up">
                            <button type="submit" class="mil-btn mil-a2 mil-c-gone">Gönder</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="mil-image-box mil-c-gone">
                <div class="mil-image-frame">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3004.6064254678645!2d28.464276076325017!3d41.14311701111078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b54522d4a7de7f%3A0x615064d4f73e31ab!2zRmVyaGF0cGHFn2EsIFLEsXphIMOWemRlbiBTb2thxJ_EsSwgMzQ1NDAgw4dhdGFsY2EvxLBzdGFuYnVs!5e0!3m2!1str!2str!4v1741285660317!5m2!1str!2str"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                        <br><a href="contact-frl.html" class="mil-text-link mil-a2 mil-c-gone">kişisel verilerin işlenme
                            kurallarını</a>
                        kabul etmiş olursunuz.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- contact form end -->
@endsection