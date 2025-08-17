<!-- subscribe -->
<div class="container">
    <div class="mil-half-container mil-reverse mil-up">
        <div class="mil-text-box mil-g-m3 mil-p-160-160">
            <p class="mil-stylized mil-m2 mil-mb60 mil-up">HABERDAR OLUN.</p>
            <h2 class="mil-display3 mil-rubber mil-mb60 mil-up">ADRESİNİ <span class="mil-a2">YAZ</span> <br>BİZE GÖNDER
            </h2>
            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif

            
            
            <form class="mil-subscribe-form mil-c-gone" method="POST" action="{{ route('subscribe.store') }}">
                @csrf
                <input type="email" name="email" placeholder="E-POSTANIZI GİRİNİZ." required>
                <button type="submit"><i class="fal fa-arrow-right"></i></button>
            </form>

        </div>
        <div class="mil-image-box">
            <div class="mil-image-frame">
                <!-- image background <img src="site/assets/img/home-1/3.jpg" alt="img" class="mil-scale-img" data-value-1="1.25" data-value-2="1">-->
                <video class="mil-scale-img" data-value-1="1" data-value-2="1.1" autoplay="autoplay" loop="loop"
                    muted="" playsinline="" oncontextmenu="return false;" preload="auto">
                    <source src="{{ asset('site/assets/img/home-1/4.mp4') }}">
                </video>
            </div>
        </div>
    </div>
    <div class="row mil-aic mil-jcb mil-no-g">
        <div class="col-lg-6">
            <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
        </div>
        <div class="col-lg-6 mil-992-gone">
            <div class="mil-text-pad">
                <p class="mil-text-sm mil-up">Gönder butonuna tıklayarak,
                    <br><a href="{{ route('site.kvkk') }}" class="mil-text-link mil-a2 mil-c-gone">kişisel verilerin işlenme
                        kurallarını</a>
                    kabul etmiş olursunuz.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- subscribe end -->


