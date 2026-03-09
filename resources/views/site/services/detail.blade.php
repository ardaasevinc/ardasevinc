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
                {{-- SOL KOLON: Açıklamalar ve Badge Listesi --}}
                <div class="col-lg-7">
                    <div class="rich-content mil-up">
                        @if ($service->desc)
                            <div class="mil-text-md mil-mb30" style="font-weight: 500; color: #111;">{!! $service->desc !!}</div>
                        @endif
                            @if ($service->desc1)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc1 !!}</div> @endif
                            @if ($service->desc2)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc2 !!}</div> @endif
                            @if ($service->desc3)
                            <div class="mil-text-sm mil-mb30">{!! $service->desc3 !!}</div> @endif

                            {{-- BADGE ALANI (Itemlar buraya geldi) --}}
                            <div class="mil-service-badges mil-up mil-mt60">
                                @if($service->item1) <span class="mil-badge">{{ $service->item1 }}</span> @endif
                                @if($service->item2) <span class="mil-badge">{{ $service->item2 }}</span> @endif
                                @if($service->item3) <span class="mil-badge">{{ $service->item3 }}</span> @endif
                                @if($service->item4) <span class="mil-badge">{{ $service->item4 }}</span> @endif
                            </div>
                            </div>
                            </div>

                {{-- SAĞ KOLON: Sadece Iframe --}}
                <div class="col-lg-4">
                    @if (!empty($service->iframe))
                        <div class="mil-iframe-frame mil-up">
                            <div class="mil-iframe-content">
                                {!! $service->iframe !!}
                            </div>
                        </div>
                    @endif
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

    {{-- CSS Düzenlemeleri --}}
    <style>
        /* Badge Tasarımı */
        .mil-service-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 40px;
        }
        .mil-badge {
            background: #f8f8f8;
            color: #af9455;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        .mil-badge:hover {
            background: #af9455;
            color: #fff;
            border-color: #af9455;
            transform: translateY(-3px);
        }

        /* Iframe Story Formatı (1080x1920 Scalable) */
        .mil-iframe-frame {
            position: relative;
            transition: transform 0.4s ease;
            width: 100%;
            max-width: 400px; /* Story genişliği için ideal sınır */
            margin: 0 auto;
        }
        .mil-iframe-content {
            position: relative;
            width: 100%;
            padding-top: 177.77%; /* 9:16 Ratio */
            border-radius: 30px; /* Daha yumuşak köşeler */
            overflow: hidden;
            background: #111;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .mil-iframe-content iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
            border: none;
        }
        .mil-iframe-frame:hover {
            transform: translateY(-10px);
        }

        @media (max-width: 991px) {
            .mil-iframe-frame { margin-top: 60px; }
            .mil-service-badges { justify-content: center; }
        }
    </style>
@endsection
