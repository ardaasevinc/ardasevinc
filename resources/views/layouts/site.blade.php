<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Ayarları --}}
    <title>
        {{ !empty($settings['SEO_TITLE']) ? html_entity_decode(strip_tags($settings['SEO_TITLE'])) : config('app.name') }}
    </title>


    @if (!empty($settings['SEO_DESCRIPTION']))
        <meta name="description" content="{{ strip_tags($settings['SEO_DESCRIPTION']) }}">
    @endif

    @if (!empty($settings['SEO_KEYWORDS']))
        <meta name="keywords" content="{{ strip_tags($settings['SEO_KEYWORDS']) }}">
    @endif
    <link rel="manifest" href="{{asset('/manifest.json')}}">
    <meta name="theme-color" content="#ffffff">

    {{-- Google Analytics --}}
    @if (!empty($settings['GOOGLE_ANALYTICS_ID']))
        <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ strip_tags($settings['GOOGLE_ANALYTICS_ID']) }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ strip_tags($settings['GOOGLE_ANALYTICS_ID']) }}');
        </script>
    @endif

    {{-- Google Tag Manager --}}
    @if (!empty($settings['GOOGLE_TAG_MANAGER_ID']))
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
                var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true; j.src = 'https://www.googletagmanager.com/gtm.js?id=' + strip_tags($settings['GOOGLE_TAG_MANAGER_ID']) + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ strip_tags($settings['GOOGLE_TAG_MANAGER_ID']) }}');</script>
    @endif

    {{-- Google reCAPTCHA --}}
    @if (!empty($settings['GOOGLE_RECAPTCHA_SITE_KEY']))
        <script
            src="https://www.google.com/recaptcha/api.js?render={{ strip_tags($settings['GOOGLE_RECAPTCHA_SITE_KEY']) }}"></script>
    @endif

    {{-- Google Maps API --}}
    @if (!empty($settings['GOOGLE_MAPS_API_KEY']))
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ strip_tags($settings['GOOGLE_MAPS_API_KEY']) }}"></script>
    @endif


    <link rel="icon" href="{{asset('site/assets/img/favicon.svg')}}" type="image/x-icon">

    {{-- Facebook Pixel --}}
    @if (!empty($settings['FACEBOOK_PIXEL_ID']))
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return; n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
                n.queue = []; t = b.createElement(e); t.async = !0;
                t.src = v; s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ strip_tags($settings['FACEBOOK_PIXEL_ID']) }}');
            fbq('track', 'PageView');
        </script>
    @endif

    {{-- Özel CSS Dosyası --}}
    @if (!empty($settings['CUSTOM_CSS']))
        <link rel="stylesheet" href="{{ asset(strip_tags($settings['CUSTOM_CSS'])) }}">
    @endif

    {{-- Özel JS Dosyası --}}
    @if (!empty($settings['CUSTOM_JS']))
        <script src="{{ asset(strip_tags($settings['CUSTOM_JS'])) }}" defer></script>
    @endif


    <!-- grid css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/bootstrap-grid.css') }}">
    <!-- font awesome css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/fontawesome.min.css') }}">
    <!-- swiper css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/swiper.min.css') }}">
    <!-- okai css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/style-friendly.css') }}">

    <!-- page title -->
    <title>Pixy</title>

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