@extends('layouts.site')

@section('content')
    <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
        <div class="container mil-hero-main mil-relative mil-aic">
            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                <div class="mil-text-pad"></div>
                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                    <li><a href="{{ route('site.blog') }}">Blog</a></li>
                    <li><a href="#.">{{ $page_title }}</a></li>
                </ul>
                {{-- Mobilde çok büyük durmaması için mil-display3 yanına mobil uyumlu font sınıfları eklenebilir --}}
                <h1 class="mil-display3 mil-rubber">{{$blog->title}}</h1>
            </div>
            <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                <div class="mil-s-3"><img src="{{asset('site/assets/img/shapes/3.png')}}" alt="shape"></div>
            </div>
        </div>
    </div>
    <div class="mil-p-0-160">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @if(!empty($blog->img1))
                        <div class="mil-project-img mil-land mil-up mil-mb60">
                            <img src="{{ asset('uploads/' . $blog->img1) }}" alt="{{$blog->title}}" class="mil-scale-img"
                                data-value-1="1.15" data-value-2="1" style="width: 100%; height: auto; object-fit: cover;">
                        </div>
                    @endif
                </div>
                
                {{-- İçerik Alanı --}}
                <div class="col-lg-10 col-xl-8">
                    @if(!empty($blog->desc))
                        {{-- 'rich-content' sınıfı aşağıda CSS ile detaylandırılmıştır --}}
                        <div class="rich-content mil-text-xl mil-up mil-mb60">
                            {!! $blog->desc !!}
                        </div>
                    @endif

                    @if (!empty($blog->media) && $blog->media->isNotEmpty())
                        <div class="row">
                            @foreach($blog->media as $image)
                                <div class="col-sm-6 col-12 mil-mb30">
                                    <div class="mil-project-img mil-up">
                                        <img src="{{ asset(!empty($image->image) ? 'uploads/' . $image->image : 'uploads/default.jpg') }}"
                                            alt="gallery" class="mil-scale-img" data-value-1="1.15" data-value-2="1" 
                                            style="width: 100%; border-radius: 10px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
    @include('site.components.subscribe')

@endsection

{{-- CSS Bölümü: Bunu ana CSS dosyanıza veya bu sayfanın @push('css') alanına ekleyin --}}
<style>
    /* Rich Editor (Zengin Metin) Mobil Uyumluluk Kalkanı */
    .rich-content {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        line-height: 1.6;
    }

    /* Editörden gelen resimlerin dışarı taşmasını engeller */
    .rich-content img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
        margin: 20px auto;
        border-radius: 8px;
    }

    /* Editörden gelen tablolar mobilde yatay kaydırılabilir olur */
    .rich-content table {
        width: 100% !important;
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-collapse: collapse;
    }

    /* Mobilde yazı boyutunu bir tık optimize edelim */
    @media (max-width: 768px) {
        .rich-content {
            font-size: 16px !important;
        }
        .mil-display3 {
            font-size: 2.5rem !important; /* Başlığın mobilde devasa görünmesini engeller */
        }
        .mil-p-0-160 {
            padding-bottom: 80px !important; /* Alt boşluğu mobilde daraltır */
        }
    }
</style>