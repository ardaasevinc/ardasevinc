<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Ayarları --}}
    <title>{{ $settings?->meta_title ?? $settings?->site_name ?? config('app.name') }}</title>
    
    @if($settings?->meta_desc)
        <meta name="description" content="{{ $settings->meta_desc }}">
    @endif

    @if($settings?->meta_keywords)
        <meta name="keywords" content="{{ $settings->meta_keywords }}">
    @endif

    {{-- Favicon --}}
    <link rel="icon" href="{{ $settings?->favicon ? asset('uploads/' . $settings->favicon) : asset('site/assets/img/favicon.svg') }}" type="image/x-icon">

    {{-- Sosyal Medya Önizleme (OG Image) --}}
    @if($settings?->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $settings->og_image) }}">
    @endif

    {{-- Google Analytics --}}
    @if($settings?->google_analytics_code)
        {!! $settings->google_analytics_code !!}
    @endif

    {{-- Facebook Pixel --}}
    @if($settings?->facebook_pixel_code)
        {!! $settings->facebook_pixel_code !!}
    @endif

    {{-- Panelden Eklenen Özel Head Scriptleri (CSS vb.) --}}
    @if($settings?->header_scripts)
        {!! $settings->header_scripts !!}
    @endif

    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/bootstrap-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/style-friendly.css') }}">
</head>
@include('site.components.success')
<body>

    <!-- wrapper -->
    <div id="smooth-wrapper" class="mil-page-wrapper">

        <div id="swup-opm"></div>

        <!-- cursor -->
        <div class="mil-cursor-follower"></div>
        <!-- cursor end -->

        {{-- @include('site.components.preloader') --}}

        <!-- scroll progress -->
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>
        <!-- scroll progress end -->

        @include('site.components.menu')
         @include('site.components.whatsapp')

        <!-- page transition -->
        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

                <!-- content -->
                <div id="smooth-content" class="mil-content">
                   
                    @yield('content')
                    
                    @include('site.components.footer')
                </div>
                <!-- content -->
               


            </div>
        </div>
        <!-- page transition -->

    </div>
    <!-- wrapper end -->

    <!-- swup js -->
    <script src="{{ asset('site/assets/js/plugins/swup.min.js') }}"></script>
    <!-- gsap js -->
    <script src="{{ asset('site/assets/js/plugins/gsap.min.js') }}"></script>
    <!-- scroll smoother -->
    <script src="{{ asset('site/assets/js/plugins/ScrollSmoother.min.js') }}"></script>
    <!-- scroll trigger js -->
    <script src="{{ asset('site/assets/js/plugins/ScrollTrigger.min.js') }}"></script>
    <!-- scroll to js -->
    <script src="{{ asset('site/assets/js/plugins/ScrollTo.min.js') }}"></script>
    <!-- swiper js -->
    <script src="{{ asset('site/assets/js/plugins/swiper.min.js') }}"></script>
    <!-- parallax js -->
    <script src="{{ asset('site/assets/js/plugins/parallax.js') }}"></script>

    <!-- pixy js -->
    <script src="{{ asset('site/assets/js/main.js') }}"></script>


</body>

</html>