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
                        <h1 class="mil-display2 mil-rubber">{{$service->title}}</h1>
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

        <!-- title -->
        <div class="container mil-relative">
            <div class="row mil-jcc">
            @if(!empty($service->desc))
                <div class="col-md-10">
                    <h1 class="mil-head2 mil-tac mil-mb160 mil-up"><span class="mil-a2">UI/UX</span> {!! strip_tags($service->desc) !!} <span class="mil-a2"></span> </h1>
                </div>
                @endif
            </div>
        </div>
        <!-- title end -->

        @include('site.components.iconboxes')

        <!-- service -->
        <div class="mil-p-0-100 mil-relative">
            <div class="container">
                <div class="row mil-jcb">
                    <div class="col-md-5">
                        <p class="mil-text-md mil-mb60 mil-up">{!! strip_tags($service->desc) !!}</p>
                        <div class="mil-team-quote mil-mb60 mil-up">
                            {{-- <div class="mil-portrait">
                                <img src="{{ asset('site/assets/img/team/ceo.jpg') }}" alt="SEO portrait">
                            </div> --}}

                        </div>
                        @if(!empty($service->number))
                        <div class="mil-counter-item mil-mb160 mil-up">
                            <h4 class="mil-up">{{$service->number}}<span class="mil-a2">+</span></h4>
                            <div class="mil-counter-text">
                                <h5 class="mil-head4 mil-m1 mil-up">{{$service->number_title}}</h5>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">

                        <p class="mil-text-md mil-mb60 mil-up">{!! strip_tags($service->desc1) !!}</p>
                        <p class="mil-text-md mil-mb60 mil-up">{!! strip_tags($service->desc2) !!}</p>
                        <p class="mil-text-md mil-mb60 mil-up">{!! strip_tags($service->desc3) !!}</p>


                    </div>
                </div>
            </div>
        </div>
        <!-- service end -->

        <!-- call to action -->
        <div class="container">
        <div class="mil-half-container mil-up">
            <div class="mil-text-box mil-g-m1 mil-p-160-160">
                <p class="mil-stylized mil-m2 mil-mb60 mil-up">Portföy</p>
                <h2 class="mil-display3 mil-rubber mil-mb60 mil-m4 mil-up">Portföyümüzü <span class="mil-a1">keşfedin</span>
                    ve ilham alın</h2>
                <div class="mil-up"><a href="{{ route('site.portfolio') }}" class="mil-btn mil-btn-border mil-m4 mil-c-gone">Portföyü Görüntüle</a></div>
            </div>
            <div class="mil-image-box">
                <div class="mil-image-frame">
                    <img src="{{ asset('site/assets/img/pages/4.jpg') }}" alt="img" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                </div>
            </div>
        </div>
        <div class="row mil-aic mil-jcb mil-no-g">
            <div class="col-lg-6">
                <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
            </div>
            <div class="col-lg-6 mil-992-gone">
                <div class="mil-text-pad">
                    <p class="mil-stylized mil-up">Bugün Daha İyi Bir Dünya Tasarlıyoruz</p>
                </div>
            </div>
        </div>
    </div>

        <!-- call to action end -->
@endsection
