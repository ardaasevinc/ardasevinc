@extends('layouts.site')

@section('content')
    <!-- hero -->
    <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
        <div class="container mil-hero-main mil-relative mil-aic">
            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                <div class="mil-text-pad"></div>
                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                    <li>
                        <a href="{{ route('site.blog') }}">Blog</a>
                    </li>
                    <li>
                        <a href="#.">{{ $page_title }}</a>
                    </li>
                </ul>
                <h1 class="mil-display3 mil-rubber">{{$blog->title}}</h1>
            </div>
            <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                <div class="mil-s-3"><img src="{{asset('site/assets/img/shapes/3.png')}}" alt="shape"></div>
            </div>
        </div>
    </div>
    <!-- hero end -->

    <!-- publication -->
    <div class="mil-p-0-160">
        <div class="container">
            <div class="row mil-jcc mil-aic">
                <div class="col-lg-12">
                    @if(!empty($blog->img1))
                        <div class="mil-project-img mil-land mil-up">
                            <img src="{{ asset('uploads/' . $blog->img1) }}" alt="project" class="mil-scale-img"
                                data-value-1="1.15" data-value-2="1">
                        </div>
                    @endif
                </div>
                <div class="col-lg-8 ">
                    @if(!empty($blog->desc))
                        <p class="mil-text-xl mil-m1 mil-mb60 mil-up">{!! $blog->desc !!}</p>
                    @endif
                    @if (!empty($blog->media) && $blog->media->isNotEmpty())
                        <div class="row mil-mb60">
                            @foreach($blog->media as $image)
                                <div class="col-lg-6 mt-5">
                                    <div class="mil-project-img mil-land mil-up mil-mb30">
                                        <img src="{{ asset(!empty($image->image) ? 'uploads/' . $image->image : 'uploads/default.jpg') }}"
                                            alt="project" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                   
                    @endif


                </div>
            </div>
        </div>
    </div>
    <!-- publication end -->

    {{-- @include('site.components.blog') --}}

    @include('site.components.subscribe')

@endsection