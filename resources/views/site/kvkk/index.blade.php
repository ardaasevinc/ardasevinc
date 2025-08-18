@extends('layouts.site')

@section('content')
    <!-- hero -->
    <div class="mil-hero-1 mil-sm-hero mil-up" id="top">
        <div class="container mil-hero-main mil-relative mil-aic">
            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                <div class="mil-text-pad"></div>
                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                    <li>
                        <a href="{{ route('site.index') }}">Anasayfa</a>
                    </li>
                    <li>
                        <a href="#.">{{ $page_title }}</a>
                    </li>
                </ul>
                <div class="mil-word-frame">
                    <h1 class="mil-display2 mil-rubber"> <span class="mil-a2">KVKK</span> METNİ</h1>
                    <div class="mil-s-4"><img src="{{ asset('site/assets/img/shapes/4.png') }}" alt="shape"></div>
                </div>
            </div>
            <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
                <div class="mil-s-2"><img src="{{ asset('site/assets/img/shapes/2.png') }}" alt="shape"></div>
                <div class="mil-s-3"><img src="{{ asset('site/assets/img/shapes/3.png') }}" alt="shape"></div>
            </div>
        </div>
    </div>
    <!-- hero end -->


    <div class="mil-p-0-100">
        <div class="container">
            <b>Kişisel Verilerin Korunması Aydınlatma Metni</b><br><br>

            <b>Arda Sevinç</b> olarak; 6698 sayılı <b>Kişisel Verilerin Korunması Kanunu (KVKK)</b> kapsamında kişisel
            verilerinizin güvenliği ve gizliliğini sağlamayı önemsiyoruz.<br><br>

            <b>1. Veri Sorumlusu</b><br>
            Bu internet sitesi (<b>ardasevinc.com.tr</b>) üzerinden elde edilen kişisel verileriniz, veri sorumlusu
            sıfatıyla <b>Arda Sevinç</b> tarafından işlenmektedir.<br><br>

            <b>2. İşlenen Kişisel Veriler</b><br>
            Sitemiz üzerinden form doldurmanız, iletişim kurmanız veya üyelik/abonelik işlemleriniz kapsamında aşağıdaki
            kişisel verileriniz işlenebilir:<br>
            - Kimlik Bilgileri (Ad, Soyad)<br>
            - İletişim Bilgileri (E-posta, Telefon)<br>
            - İşlem Güvenliği Bilgileri (IP adresi, log kayıtları, tarayıcı bilgileri)<br>
            - Mesaj içerikleri ve talepler<br><br>

            <b>3. Kişisel Verilerin İşlenme Amaçları</b><br>
            Toplanan kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:<br>
            - İletişim taleplerinizi yanıtlamak, hizmet sunmak<br>
            - Ürün/hizmet tanıtımı ve bilgilendirme yapmak (onay vermeniz halinde)<br>
            - Yasal yükümlülüklerimizi yerine getirmek<br><br>

            <b>4. Kişisel Verilerin Aktarımı</b><br>
            Kişisel verileriniz, yalnızca mevzuat gereklilikleri çerçevesinde ve gerekli durumlarda yetkili kurum ve
            kuruluşlarla paylaşılabilir. Bunun dışında üçüncü kişilerle paylaşılmaz.<br><br>

            <b>5. Kişisel Veri Toplama Yöntemi ve Hukuki Sebep</b><br>
            Kişisel verileriniz; internet sitemizdeki formlar, iletişim kanalları, çerezler ve benzeri teknolojiler
            aracılığıyla, KVKK’nın 5. ve 6. maddelerinde belirtilen hukuki sebepler doğrultusunda toplanmaktadır.<br><br>

            <b>6. Haklarınız</b><br>
            KVKK’nın 11. maddesi uyarınca, veri sahibi olarak;<br>
            - Kişisel verilerinizin işlenip işlenmediğini öğrenme,<br>
            - İşlenmişse buna ilişkin bilgi talep etme,<br>
            - İşleme amacını öğrenme ve amacına uygun kullanılıp kullanılmadığını sorgulama,<br>
            - Kişisel verilerinizin silinmesini veya anonim hale getirilmesini talep etme,<br>
            haklarına sahipsiniz.<br><br>

            Haklarınızı kullanmak için bizimle <b>info@ardasevinc.com.tr</b> adresi üzerinden iletişime
            geçebilirsiniz.<br><br>

            <b>Arda Sevinç</b><br>
            <b>ardasevinc.com.tr</b><br>

        </div>
    </div>
@endsection