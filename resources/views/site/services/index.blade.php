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
                    <h1 class="mil-display2 mil-rubber"> <span class="mil-a2">{{ $page_title }}</span></h1>
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

    <!-- services -->
    <div class="mil-relative">
        <div class="container">
            <div class="row">

                @foreach($service as $item)
                    <div class="col-lg-4">
                        <div class="mil-service-card-lg mil-mb160">
                            <h3 class="mil-head3 mil-mb60 mil-up">{{$item->title}}</h3>
                            <p class="mil-text-md mil-shortened mil-mb60 mil-up">{!! Str::limit(strip_tags($item->desc)) !!}</p>
                            <ul class="mil-mb60">
                                @if(!empty($item->item1))
                                    <li class="mil-up">{!! Str::limit(strip_tags($item->item1)) !!}</li>
                                @endif

                                @if(!empty($item->item2))
                                    <li class="mil-up">{!! Str::limit(strip_tags($item->item2)) !!}</li>
                                @endif

                                @if(!empty($item->item3))
                                    <li class="mil-up">{!! Str::limit(strip_tags($item->item3)) !!}</li>
                                @endif

                                @if(!empty($item->item4))
                                    <li class="mil-up">{!! Str::limit(strip_tags($item->item4)) !!}</li>
                                @endif

                            </ul>
                            <div class="mil-mb30 mil-up">
                                <a href="{{route('site.services.detail', ['slug' => $item->slug])}}"
                                    class="mil-stylized-btn mil-c-gone">
                                    <i class="fal fa-arrow-up"></i>
                                    <span>Daha Fazlası</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- services end -->

    <!-- call to action -->
    <div class="container">
        <div class="mil-half-container mil-up">
            <div class="mil-text-box mil-g-m1 mil-p-160-160">
                <p class="mil-stylized mil-m2 mil-mb60 mil-up">PROJELERİMİZ</p>
                <h2 class="mil-display3 mil-rubber mil-mb60 mil-m4 mil-up">Projelerimizi <span class="mil-a1">merak</span>
                    ediyor musunuz?</h2>
                <div class="mil-up"><a href="{{route('site.portfolio')}}" class="mil-btn mil-btn-border mil-m4 mil-c-gone">Projelere Git</a></div>
            </div>
            <div class="mil-image-box">
                <div class="mil-image-frame">
                    <img src="{{ asset('site/assets/img/pages/4.jpg') }}" alt="img" class="mil-scale-img"
                        data-value-1="1.20" data-value-2="1">
                </div>
            </div>
        </div>
        <div class="row mil-aic mil-jcb mil-no-g">
            <div class="col-lg-6">
                <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
            </div>
            <div class="col-lg-6 mil-992-gone">
                <div class="mil-text-pad">
                    <p class="mil-stylized mil-up">Daha iyi bir Dünya tasarlamak için...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- call to action end -->

@endsection