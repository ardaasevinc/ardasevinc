<footer class="mil-footer mil-p-160-160">
    <div class="container">
        <div class="row mil-no-g">
            <div class="col-lg-6 mil-up">
                {{-- Telefon varsa ara, yoksa iletişim sayfasına git --}}
                <a href="{{ $settings?->phone ? 'tel:' . $settings->phone : route('site.contact') }}" class="mil-footer-contact mil-mb90">
                    <h6 class="mil-footer-link mil-rubber mil-m1">{{ $settings?->slogan ?? 'ŞİMDİ ARA!' }}</h6>
                    <span class="mil-stylized-btn mil-c-gone">
                        <i class="fal fa-arrow-up"></i>
                        <span>Bize Ulaşın</span>
                    </span>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="mil-footer-menu-frame mil-mb90 mil-up">
                    <ul class="mil-footer-menu">
                        <li><a href="{{ route('site.index') }}">ANASAYFA</a></li>
                        <li><a href="{{ route('site.services') }}">HİZMETLERİMİZ</a></li>
                        <li><a href="{{ route('site.portfolio') }}">PROJELERİMİZ</a></li>
                        <li><a href="{{ route('site.blog') }}">BLOGLAR</a></li>
                        <li><a href="{{ route('site.contact') }}">BİZE ULAŞIN</a></li>
                    </ul>
                    <ul class="mil-social mil-c-gone">
                         @if($settings->twitter_url)
                            <li><a href="{{ $settings->twitter_url }}" target="_blank" data-no-swup title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        @endif
                        @if($settings->instagram_access_token)
                            <li><a href="{{ $settings->instagram_access_token }}" target="_blank" data-no-swup title="Instagram"><i class="fab fa-instagram"></i></a></li>
                        @endif
                        @if($settings->linkedin_url)
                            <li><a href="{{ $settings->linkedin_url }}" target="_blank" data-no-swup title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                        @endif
                        @if($settings->youtube_url)
                            <li><a href="{{ $settings->youtube_url }}" target="_blank" data-no-swup title="YouTube"><i class="fab fa-youtube"></i></a></li>
                        @endif
                        @if($settings->facebook_url)
                            <li><a href="{{ $settings->facebook_url }}" target="_blank" data-no-swup title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mil-footer-bottom mil-up">
                    <p class="mil-text-sm">©{{ date('Y') }}. {{ $settings?->site_name ?? config('app.name') }}</p>
                    <p class="mil-text-sm">Tasarlandı: <a href="#" class="mil-text-link mil-a2">Arda Sevinç</a></p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Footer Scriptleri (Canlı destek, Body sonu kodları) --}}
    @if($settings?->footer_scripts)
        {!! $settings->footer_scripts !!}
    @endif
</footer>