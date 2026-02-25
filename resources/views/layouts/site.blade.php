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

 {{-- Google Analytics (GTAG.js) --}}
@if(!empty($settings?->google_analytics_code))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_code }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings->google_analytics_code }}');
    </script>
@endif

{{-- Facebook Pixel --}}
@if(!empty($settings?->facebook_pixel_code))
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings->facebook_pixel_code }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" 
             src="https://www.facebook.com/tr?id={{ $settings->facebook_pixel_code }}&ev=PageView&noscript=1"/>
    </noscript>
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