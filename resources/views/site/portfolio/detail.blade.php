@extends('layouts.site')

@section('content')
            <!-- hero -->
            <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
                <div class="container mil-hero-main mil-relative mil-aic">
                    <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                        <div class="mil-text-pad"></div>
                        <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                            <li>
                                <a href="{{ route('site.portfolio') }}">Hizmetlerimiz</a>
                            </li>
                            <li>
                                <a href="#.">{{ $page_title }}</a>
                            </li>
                        </ul>
                        <h1 class="mil-display2 mil-rubber">{{$portfolio->title}}</h1>
                    </div>
                    <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                        <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                        <div class="mil-s-3"><img src="{{ asset('site/assets/img/shapes/3.png') }}" alt="shape"></div>
                    </div>
                </div>
            </div>
            <!-- hero end -->

            <!-- details -->
            <div id="scroll">
                <div class="container">
                    <div class="row mil-jcb mil-aic">
                        <div class="col-lg-6 mil-mb160">
                            <div class="mil-project-img mil-port ">
                                <img src="{{ asset('uploads/' . $portfolio->img1) }}" alt="project" 
                                    data-value-2="1">
                            </div>
                        </div>
                        <div class="col-lg-5 mil-mb160">
                            <p class="mil-stylized mil-m2 mil-mb60 mil-up">Proje Hakkında</p>
                            <h2 class="mil-head1 mil-mb60 mil-up"> <br><span class="mil-a1">{{$portfolio->title}}</span></h2>
                            <p class="mil-text-md mil-mb60 mil-up">{!! $portfolio->desc !!}</p>
                            <div class="mil-team-quote mil-up">

                                <div class="mil-portrait">
                                    <img src="{{ asset('site/assets/img/team/ceo.jpg') }}" alt="SEO portrait">
                                </div>

                                <p class="mil-text-md mil-m1"><span class="mil-bold">Passionately Creating</span> Design Wonders:
                                    <br><span class="mil-bold">Unleashing</span> Boundless Creativity</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @if ($portfolio->media && $portfolio->media->isNotEmpty())
        <div class="mil-p-0-130">
            <div class="container">
                <div class="row mil-mb60">
                    @foreach($portfolio->media as $image)
                        <div class="col-lg-6">
                            <div class="mil-project-img mil-square mil-mb30 mil-up">
                                <img src="{{ asset($image->media_path ? 'uploads/' . $image->media_path : 'uploads/default.jpg') }}"
                                    alt="project" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
 
    @endif



            <div class="mil-p-0-160">
                <div class="container mil-relative">
                    <div class="mil-objects">
                        <div class="mil-obj-1"></div>
                        <div class="mil-obj-2"></div>
                    </div>
                    <h2 class="mil-head1 mil-rubber mil-taс mil-up">Yaratıcı <span class="mil-a1">fikirlerle</span> ile büyüyoruz
                        Her an <span class="mil-a2">etkileyici projeler</span> üretiyoruz</h2>
                </div>
            </div>
            <!-- details end -->

            <!-- next project -->
            @if ($nextportfolio)
                <!-- next project -->
                <div class="container">
                    <div class="mil-half-container mil-up">
                        <div class="mil-text-box mil-g-m1 mil-p-160-160">
                            <p class="mil-stylized mil-a1 mil-mb60 mil-up">Sonraki Proje</p>
                            <h2 class="mil-display3 mil-mb60 mil-m4 mil-up">{{ $nextportfolio->title }}</h2>
                            <p class="mil-text-md mil-deco-text mil-shortened mil-mb60 mil-up">
                                {{ Str::limit($nextportfolio->desc, 100) }}
                            </p>
                            <div class="mil-up">
                                <a href="{{ route('site.portfolio.detail', ['slug' => $nextportfolio->slug]) }}"
                                    class="mil-btn mil-btn-border mil-m4 mil-c-gone">
                                    Projeyi Gör
                                </a>
                            </div>
                        </div>
                        <div class="mil-image-box">
                            <div class="mil-image-frame">
                                <img src="{{ asset($nextportfolio->img1 ? 'uploads/' . $nextportfolio->img1 : 'uploads/default.jpg') }}"
                                    alt="{{ $nextportfolio->title }}" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
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
                                <p class="mil-stylized mil-up">Daha İyi Bir Dünya Tasarlamak</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- next project end -->
            @endif

            <!-- next project end -->
            @include('site.components.subscribe')

@endsection
