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
                    <h1 class="mil-display2 mil-rubber">BLOGLAR</h1>
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

    <!-- blog -->
    <div class="mil-p-160-160">
        <div class="container">
            <div class="row mil-aie mil-mb30">
                <div class="col-md-6">
                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">Haberler</p>
                    <h2 class="mil-head1 mil-mb60 mil-up">En yeni <span class="mil-a2">Haberler</span>
                    </h2>
                </div>
                <div class="col-md-6">
                    <p class="mil-stylized mil-m1 mil-tar mil-768-tal mil-mb60 mil-up">
                        {{-- <a href="#" class="mil-arrow-link mil-c-gone">Tüm Haberler</a></p> --}}
                </div>
            </div>
            <div class="swiper-container mil-blog-slider">
                <div class="swiper-wrapper mil-c-swipe mil-c-light">


                    @foreach($blog as $item)

                        <div class="swiper-slide">
                            <div class="mil-blog-card">
                                <div class="mil-cover mil-up">
                                    <div class="mil-hover-frame">
                                        @if(!empty($item->img1))
                                            <img src="{{ asset('uploads/' . $item->img1) }}" alt="cover" class="mil-scale-img"
                                                data-value-1="1.15" data-value-2="1">
                                        @else
                                            <img src="{{ asset('uploads/default.jpg') }}" alt="cover" class="mil-scale-img">
                                        @endif
                                    </div>
                                    <div class="mil-badges">
                                        <div class="mil-category">{{ $item->category->name ?? 'Kategori Yok' }}</div>
                                        <div class="mil-date">{{ $item->created_at }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('site.blog.detail', ['id' => $item->id]) }}" class="mil-descr mil-c-gone">
                                    <div class="mil-text-frame">
                                        <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">
                                            {{ $item->title ?? 'Başlık Yok' }}
                                        </h4>
                                        <p class="mil-text-md mil-max-2row-text mil-up">
                                            {!! Str::limit(strip_tags($item->desc) ?? 'Açıklama mevcut değil.', 250) !!}
                                        </p>
                                    </div>
                                    <div class="mil-up mil-768-gone">
                                        <div class="mil-stylized-btn">
                                            <i class="fal fa-arrow-up"></i>
                                            <span>Daha Fazlası</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach





                </div>
            </div>
        </div>
    </div>
    <!-- blog end -->
    <!-- blog -->
    <div class="mil-p-0-100">
        <div class="container">
            <div class="row mil-aie mil-mb30">
                <div class="col-md-6">
                    <h2 class="mil-head1 mil-mb60 mil-up">En yeni <span class="mil-a2">Yayınlar</span></h2>
                </div>
            </div>
            <div class="row">

                @foreach($blog as $item)
                                        <div class="col-lg-12">
                                            <div class="mil-blog-card mil-type-2 mil-mb60">
                                                <div class="mil-cover mil-up">
                                                    <div class="mil-hover-frame">
                                                        <img src="{{ asset('uploads/' . $item->img1) }}" alt="cover" class="mil-scale-img"
                                                            data-value-1="1.15" data-value-2="1">
                                                    </div>
                                                    <div class="mil-badges">
                                                        <div class="mil-category">{{$item->category->name}}</div>
                                                        <div class="mil-date">{{ $item->created_At }}</div>
                                                    </div>
                                                </div>
                                                <a href="{{route('site.blog.detail', ['id' => $item->id])}}" class="mil-descr mil-c-gone">
                                                    <div class="mil-text-frame">
                                                        <h4 class="mil-head3 mil-max-2row-text mil-mb30 mil-up">{{$item->title}}</h4>
                                                        <p class="mil-text-md mil-max-2row-text mil-mb40 mil-up">{!! Str::limit(strip_tags($item->desc), 200) !!}
                    </p>
                                                        <div class="mil-up">
                                                            <div class="mil-btn mil-a2 mil-c-gone">Daha Fazlası</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                @endforeach

            </div>
        </div>
    </div>
    <!-- blog end -->

    <!-- pagination -->
    @if ($blog->hasPages())
        <div class="mil-p-0-160">
            <div class="container">
                <div class="mil-blog-pagination">
                    <ul>
                        <!-- Önceki Sayfa Butonu -->
                        @if ($blog->onFirstPage())
                            <li class="disabled"><span><i class="far fa-arrow-left"></i></span></li>
                        @else
                            <li><a href="{{ $blog->previousPageUrl() }}"><span><i class="far fa-arrow-left"></i></span></a></li>
                        @endif

                        <!-- Sayfa Numaraları -->
                        @foreach ($blog->links()->elements[0] as $page => $url)
                            @if ($page == $blog->currentPage())
                                <li class="mil-active"><a href="#.">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        <!-- Sonraki Sayfa Butonu -->
                        @if ($blog->hasMorePages())
                            <li><a href="{{ $blog->nextPageUrl() }}"><span><i class="far fa-arrow-right"></i></span></a></li>
                        @else
                            <li class="disabled"><span><i class="far fa-arrow-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- pagination end -->

    @include('site.components.subscribe')
@endsection