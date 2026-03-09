@extends('layouts.site')

@section('content')
        {{-- Hero Section --}}
        <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
            <div class="container mil-hero-main mil-relative mil-aic">
                <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                    <div class="mil-text-pad"></div>
                    <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                        <li><a href="{{ route('site.index') }}">Anasayfa</a></li>
                        <li><a href="#.">{{ $page_title ?? 'Hizmet Detayı' }}</a></li>
                    </ul>
                    <div class="mil-word-frame">
                        <h1 class="mil-display2 mil-rubber">{{ $service->title }}</h1>
                        <div class="mil-s-4"><img src="{{ asset('site/assets/img/shapes/4.png') }}" alt="shape"></div>
                    </div>
                </div>
                <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                    <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                    <div class="mil-s-3"><img src="{{ asset('site/assets/img/shapes/3.png') }}" alt="shape"></div>
                </div>
            </div>
        </div>

        @include('site.components.iconboxes')

        <div class="mil-p-0-100 mil-relative">
            <div class="container">
                <div class="row mil-jcb mil-mb100">
                    {{-- Açıklamalar --}}
                    <div class="col-lg-7">
                        <div class="rich-content mil-up">
                            @if ($service->desc)
                                <div class="mil-text-md mil-mb30" style="font-weight: 500; color: #111;">{!! $service->desc !!}
                            </div> @endif
                            @if ($service->desc1)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc1 !!}</div> @endif
                            @if ($service->desc2)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc2 !!}</div> @endif
                            @if ($service->desc3)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc3 !!}</div> @endif
                        </div>
                    </div>

                    {{-- İstatistikler --}}
                    <div class="col-lg-4">
                        @if (!empty($service->iframe))
                            <div class="mil-iframe-frame mil-up mil-mb60">
                                <div class="mil-iframe-content shadow-lg"
                                    style="border-radius: 20px; overflow: hidden; line-height: 0;">
                                    {!! $service->iframe !!}
                                </div>
                            </div>
                        @endif

                        <ul class="mil-list mil-up">
                            @if($service->item1)
                            <li>{{ $service->item1 }}</li> @endif
                            @if($service->item2)
                            <li>{{ $service->item2 }}</li> @endif
                            @if($service->item3)
                            <li>{{ $service->item3 }}</li> @endif
                            @if($service->item4)
                            <li>{{ $service->item4 }}</li> @endif
                        </ul>
                    </div>
                </div>

                {{-- GALERİ ALANI --}}
                @if($service->images && count($service->images) > 0)
                    <div class="mil-p-0-100">


                        <div class="row">
                            @foreach($service->images as $image)
                                <div class="col-md-4 col-sm-6 mil-mb30">
                                    <div class="mil-gallery-item mil-up">
                                        <img src="{{ asset('uploads/' . $image) }}" alt="Proje Görseli"
                                            style="width: 100%; height: auto; object-fit: cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @include('site.components.calltoaction')
        </div>

        <style>
            .mil-divider-lg {
                width: 60px;
                height: 3px;
                background: #af9455;
                margin: 0 auto;
            }
        </style>
<style>
    /* Iframe Dış Çerçevesi */
    .mil-iframe-frame {
        position: relative;
        transition: transform 0.4s ease;
        width: 100%; /* Bulunduğu kolonun genişliğine yayılır */
        max-width: 450px; /* Story formatı çok genişlemesin diye opsiyonel sınır */
        margin: 0 auto; /* Ortalamak için */
    }

    /* 9:16 Oranını Sağlayan Kapsayıcı (Story Formatı) */
    .mil-iframe-content {
        position: relative;
        width: 100%;
        padding-top: 177.77%; /* (1920 / 1080) * 100 = 177.77% */
        border-radius: 20px;
        overflow: hidden;
        background: #f0f0f0; /* İçerik yüklenene kadar gri alan */
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    /* Iframe'i Kapsayıcıya Tam Oturtma */
    .mil-iframe-content iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        border: none;
    }

    .mil-iframe-frame:hover {
        transform: translateY(-8px);
    }

    /* Tasarım Detayı: Üstteki Küçük Çizgi */
    .mil-divider-lg {
        width: 60px;
        height: 3px;
        background: #af9455;
        margin: 0 auto;
    }

    /* Mobilde Kolon Arası Boşluk */
    @media (max-width: 991px) {
        .mil-iframe-frame {
            margin-top: 50px;
        }
    }
</style>
@endsection
