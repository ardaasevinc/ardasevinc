<div class="mil-preloader">
    <div class="mil-preloader-animation">
        <div class="mil-pos-abs mil-animation-1">
            {{-- Hero modelinden gelen 3 kelimeyi göster, yoksa varsayılanları bas --}}
            <p class="mil-head1 mil-m1">
                {{ $hero->word1 ?? 'DESIGN' }}
            </p>
            <p class="mil-head1 mil-a2">
                {{ $hero->word2 ?? 'MEETS' }}
            </p>
            <p class="mil-head1 mil-m1">
                {{ $hero->word3 ?? 'FULL STACK' }}
            </p>
        </div>
        <div class="mil-pos-abs mil-animation-2">
            <div class="mil-reveal-frame">
                <p class="mil-reveal-box"></p>
                <p class="mil-head1 mil-m1">
                    {{-- Settings'ten gelen site adını veya mail adresini göster --}}
                    {{ $settings->site_name ?? 'ardasevinc.com.tr' }}
                </p>
            </div>
        </div>
    </div>
</div>