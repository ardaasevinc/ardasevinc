@if($hero)
    <div class="mil-hero-1 mil-up" id="top">
        <div class="container mil-hero-main mil-relative mil-aic">
            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                <div class="mil-text-pad"></div>
                <i class="fal fa-award mil-mb15"></i>
                
                @if(!empty($hero->top_text))
                    <p class="mil-stylized mil-m2 mil-mb60">{{ $hero->top_text }}</p>
                @endif
                
                <div class="mil-word-frame">
                    @if(!empty($hero->word1))
                        <h1 class="mil-display1 mil-rubber">{{ $hero->word1 }}</h1>
                    @endif
                    
                    @if(!empty($hero->img4))
                        <div class="mil-s-4">
                            <img src="{{ asset('uploads/' . $hero->img4) }}" alt="shape">
                        </div>
                    @endif
                </div>
                
                @if(!empty($hero->word2))
                    <h1 class="mil-display1 mil-rubber">{{ $hero->word2 }}</h1>
                @endif
                
                <div class="mil-word-frame mil-mb60">
                    @if(!empty($hero->word3))
                        <h1 class="mil-display1 mil-rubber">{{ $hero->word3 }}</h1>
                    @endif
                    
                    @if(!empty($hero->img5)) {{-- img5 alanını şekil olarak kullandık --}}
                        <div class="mil-s-5">
                            <img src="{{ asset('uploads/' . $hero->img5) }}" alt="shape">
                        </div>
                    @endif
                </div>
                
                @if(!empty($hero->bottom_text))
                    <p class="mil-stylized mil-m2">{{ $hero->bottom_text }}</p>
                @endif
            </div>

            {{-- Dekoratif şekillerden en az biri varsa bloğu göster --}}
            @if($hero->img1 || $hero->img2 || $hero->img3)
                <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                    @if($hero->img1)
                        <div class="mil-s-1"><img src="{{ asset('uploads/' . $hero->img2) }}" alt="shape"></div>
                    @endif
                    
                    @if($hero->img2)
                        <div class="mil-s-2"><img src="{{ asset('uploads/' . $hero->img5) }}" alt="shape"></div>
                    @endif
                    
                    @if($hero->img3)
                        <div class="mil-s-3"><img src="{{ asset('uploads/' . $hero->img3) }}" alt="shape"></div>
                    @endif
                </div>
            @endif
        </div>

        <div class="mil-hero-img-frame" id="scroll">
            <div class="mil-circle-text-frame mil-parallax-img" data-value-1="-60px" data-value-2="10px">
                <a href="#scroll" class="mil-circle-text mil-scroll-to mil-c-gone" data-no-swup>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 300 300" xml:space="preserve" data-value="360" class="mil-rotate">
                        <defs>
                            <path id="circlePath" d="M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 " />
                        </defs>
                        <circle cx="150" cy="100" r="75" fill="none" />
                        <g>
                            <use xlink:href="#circlePath" fill="none" />
                            <text style="letter-spacing: 2px">
                                <textPath xlink:href="#circlePath">aşağı kaydır - aşağı kaydır - aşağı kaydır - </textPath>
                            </text>
                        </g>
                    </svg>
                    <span class="mil-arrow">
                        <i class="fal fa-arrow-down"></i>
                    </span>
                </a>
            </div>
            
            <div class="mil-hero-img mil-up">
                {{-- Ana görsel varsa img1'i kullan, yoksa varsayılanı göster --}}
                <img src="{{ $hero->img1 ? asset('uploads/' . $hero->img1) : asset('site/assets/img/home-1/1.webp') }}" alt="hero" class="mil-scale-img" data-value-1="1.25" data-value-2="1">
            </div>
        </div>
    </div>
    @endif