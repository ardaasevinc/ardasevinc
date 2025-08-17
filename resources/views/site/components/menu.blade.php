<!-- fixed elements -->
<div class="mil-fixed">
    <div class="mil-top-panel">
        
        <div class="mil-left-side">
            <a href="{{ route('site.index') }}" class="mil-logo mil" data-no-swup>
                <img src="{{ asset('site/assets/logo/logo-white.svg') }}" alt="" height="75px;">
            </a>
        </div>
        <div class="mil-buttons-tp-frame mil-c-gone">
        @if(!empty($settings['CONTACT_PHONE']))
            <p class="mil-stylized mil-m1 mil-phone"><span class="mil-m2">Telefon:</span> {{ strip_tags($settings['CONTACT_PHONE'])}}</p>
            @endif
            <div class="mil-buttons">
                <a href="{{ route('site.contact') }}" class="mil-tp-btn"><i class="fal fa-envelope"></i></a>
                <div class="mil-tp-btn">
                    <div class="mil-menu-btn"><span></span></div>
                </div>
            </div>
        </div>
    </div>
    {{-- //-has-children --}}
    <div class="mil-menu-frame">
        <div class="mil-menu-window">
            <div class="mil-menu-section mil-inner-scroll" id="swupMenu">
                <ul class="mil-main-menu mil-c-gone">
                    <li class="mil">
                        <a href="{{ route('site.index') }}">ANASAYFA</a>
                    </li>
                    <li class="mil">
                        <a href="{{ route('site.contact') }}">BİZE ULAŞIN</a>
                    </li>
                    <li class="mil">
                        <a href="{{ route('site.services') }}">HİZMETLERİMİZ</a>
                    </li>
                    <li class="mil">
                        <a href="{{ route('site.portfolio') }}">PROJELERİMİZ</a>
                    </li>
                    <li class="mil">
                        <a href="{{ route('site.blog') }}">HABERLER</a>

                    </li>
                </ul>
            </div>
            <div class="mil-bottom">
                <div class="mil-blog-section">
                    <div class="mil-jcb mil-aic">
                        <h4 class="mil-head4 mil-mb30">EN YENİ HABERLER</h4>
                        <div class="mil-sb-nav mil-mb30">
                            <div class="mil-slider-btn mil-sb-prev mil-c-gone"><i class="fal fa-arrow-left"></i>
                            </div>
                            <div class="mil-slider-btn mil-sb-next mil-c-gone"><i class="fal fa-arrow-right"></i></div>
                        </div>
                    </div>

                   
                    <div class="swiper-container mil-blog-slider-sm">
                   
                        <div class="swiper-wrapper">
                        @foreach($blog_menu as $item)
                            <div class="swiper-slide">
                                <a href="{{route('site.blog.detail', ['id' => $item->id])}}" class="mil-blog-card-sm mil-c-gone">
                                    <div class="mil-cover">
                                        <div class="mil-hover-frame">
                                            <img src="{{ asset('uploads/' . $item->img1) }}" alt="cover">
                                        </div>
                                    </div>
                                    <div class="mil-text-frame">
                                        <h4 class="mil-head6 mil-max-1row-text">{{ Str::limit($item->title, 15) }}</h4>
                                    </div>
                                </a>
                            </div>
                           
                        
                            @endforeach
                        </div>
                    </div>
                   
                </div>
                <div class="mil-social-section">
                    <ul class="mil-social mil-c-gone">
                        <li><a href="#." target="_blank" data-no-swup><i class="fab fa-twitter"></i></a>
                        </li>
                        <li><a href="#." target="_blank" data-no-swup><i class="fab fa-behance"></i></a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- fixed elements end -->
