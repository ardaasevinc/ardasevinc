<div class="mil-fixed">
    <div class="mil-top-panel">
        <div class="mil-left-side">
            <a href="{{ route('site.index') }}" class="mil-logo mil" data-no-swup>
                <img src="{{ asset('uploads/' . $settings?->logo_light) }}" 
                     alt="{{ $settings->site_name ?? 'Logo' }}" 
                     style="height: 75px;">
            </a>
        </div>
        <div class="mil-buttons-tp-frame mil-c-gone">
            @if($settings->phone)
                <p class="mil-stylized mil-m1 mil-phone">
                    <span class="mil-m2">Telefon:</span>
                    {{ $settings->phone_formatted ?? $settings->phone }}
                </p>
            @endif
            <div class="mil-buttons">
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="mil-tp-btn">
                        <i class="fal fa-envelope"></i>
                    </a>
                @endif
                <div class="mil-tp-btn">
                    <div class="mil-menu-btn"><span></span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="mil-menu-frame">
        <div class="mil-menu-window">
            <div class="mil-menu-section mil-inner-scroll" id="swupMenu">
                <ul class="mil-main-menu mil-c-gone">
                    {{-- Anasayfa her zaman görünür --}}
                    <li class="mil {{ request()->routeIs('site.index') ? 'mil-active' : '' }}">
                        <a href="{{ route('site.index') }}">ANASAYFA</a>
                    </li>

                    {{-- Hizmetler verisi varsa göster --}}
                    @if(\App\Models\Service::where('is_published', true)->exists())
                        <li class="mil {{ request()->routeIs('site.services*') ? 'mil-active' : '' }}">
                            <a href="{{ route('site.services') }}">HİZMETLERİMİZ</a>
                        </li>
                    @endif

                    {{-- Portfolyo verisi varsa göster --}}
                    @if(\App\Models\PortfolioPost::where('is_published', true)->exists())
                        <li class="mil {{ request()->routeIs('site.portfolio*') ? 'mil-active' : '' }}">
                            <a href="{{ route('site.portfolio') }}">PROJELERİMİZ</a>
                        </li>
                    @endif

                    {{-- Blog yazısı varsa göster --}}
                    @if($blog->count()>0)
                        <li class="mil {{ request()->routeIs('site.blog*') ? 'mil-active' : '' }}">
                            <a href="{{ route('site.blog') }}">BLOGLAR</a>
                        </li>
                    @endif

                   
                    <li class="mil {{ request()->routeIs('site.contact') ? 'mil-active' : '' }}">
                        <a href="{{ route('site.contact') }}">BİZE ULAŞIN</a>
                    </li>
                </ul>
            </div>
            
            <div class="mil-bottom">
                {{-- Blog Slaytı - Sadece blog_menu verisi gelmişse gösterilir --}}
                @if($blog_menu && $blog_menu->count() > 0)
                    <div class="mil-blog-section">
                        <div class="mil-jcb mil-aic">
                            <h4 class="mil-head4 mil-mb30">EN YENİ HABERLER</h4>
                            <div class="mil-sb-nav mil-mb30">
                                <div class="mil-slider-btn mil-sb-prev mil-c-gone"><i class="fal fa-arrow-left"></i></div>
                                <div class="mil-slider-btn mil-sb-next mil-c-gone"><i class="fal fa-arrow-right"></i></div>
                            </div>
                        </div>

                        <div class="swiper-container mil-blog-slider-sm">
                            <div class="swiper-wrapper">
                                @foreach($blog_menu as $item)
                                    <div class="swiper-slide">
                                        <a href="{{ route('site.blog.detail', ['slug' => $item->slug]) }}" class="mil-blog-card-sm mil-c-gone">
                                            <div class="mil-cover">
                                                <div class="mil-hover-frame">
                                                    <img src="{{ $item->img1 ? asset('uploads/' . $item->img1) : asset('site/assets/img/placeholder.jpg') }}" alt="{{ $item->title }}">
                                                </div>
                                            </div>
                                            <div class="mil-text-frame">
                                                <h4 class="mil-head6 mil-max-1row-text">{{ Str::limit($item->title, 25) }}</h4>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mil-social-section">
                    <ul class="mil-social mil-c-gone">
                        @if($settings->twitter_url)
                            <li><a href="{{ $settings->twitter_url }}" target="_blank" data-no-swup title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        @endif
                        @if($settings->instagram_url)
                            <li><a href="{{ $settings->instagram_url }}" target="_blank" data-no-swup title="Instagram"><i class="fab fa-instagram"></i></a></li>
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
        </div>
    </div>
</div>