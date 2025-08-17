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
                                        <h1 class="mil-display2 mil-rubber">EN İYİ <span class="mil-a2">İŞLERİMİZ</span></h1>
                                        <div class="mil-s-4"><img src="site/assets/img/shapes/4.png" alt="shape"></div>
                                    </div>
                                </div>
                                <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                                    <div class="mil-s-2"><img src="site/assets/img/shapes/2.png" alt="shape"></div>
                                    <div class="mil-s-3"><img src="site/assets/img/shapes/3.png" alt="shape"></div>
                                </div>
                            </div>
                        </div>
                        <!-- hero end -->

                        <!-- portfolio -->
                        <div class="mil-p-0-130">
                            <div class="container-fluid">
                                <div class="row">

                                    @if(!empty($portfolio) && $portfolio->isNotEmpty())
                                        @foreach($portfolio as $item)
                                            <div class="col-md-4">
                                                <div class="mil-work-card mil-mb30">
                                                    <div class="mil-cover mil-port mil-up">
                                                        <div class="mil-hover-frame">
                                                            @if(!empty($item->img1))
                                                                <img src="{{ asset('uploads/' . $item->img1) }}" alt="cover" class="mil-scale-img" data-value-1="1.15"
                                                                    data-value-2="1">
                                                            @else
                                                                <img src="{{ asset('uploads/default.jpg') }}" alt="cover" class="mil-scale-img">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mil-hover-overlay">
                                                        @if(!empty($item->id) )
                                                            <a href="{{ route('site.portfolio.detail', ['id' => $item->id]) }}" class="mil-descr">
                                                                <div class="mil-text-frame">
                                                                    <h4 class="mil-head4 mil-max-1row-text mil-m4 mil-c-gone">{{ $item->title }}</h4>
                                                                </div>
                                                                <div class="mil-768-gone mil-c-gone">
                                                                    <div class="mil-stylized-btn mil-a1">
                                                                        <i class="fal fa-arrow-up"></i>
                                                                        <span>Daha Fazlası</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <p>Başlık veya ID eksik.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Henüz portfolyo eklenmemiş.</p>
                                    @endif



                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- portfolio end -->
                        @include('site.components.subscribe')
@endsection
