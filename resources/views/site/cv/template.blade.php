<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>{{ $cv->name }} - CV</title>
    <style>
        /* ------- Sayfa ve font tanımları ------- */
        @page { margin: 18mm 16mm; }

        /* DomPDF'de local font için @font-face */
       @font-face {
        font-family: 'Montserrat';
        src: url('{{ 'file://'.public_path('site/assets/fonts/Montserrat-Regular.ttf') }}') format('truetype');
        font-weight: 400;
        font-style: normal;
    }
    @font-face {
        font-family: 'Montserrat';
        src: url('{{ 'file://'.public_path('site/assets/fonts/Montserrat-Bold.ttf') }}') format('truetype');
        font-weight: 700;
        font-style: normal;
    }
    @font-face {
        font-family: 'Open Sans';
        src: url('{{ 'file://'.public_path('site/assets/fonts/OpenSans-Regular.ttf') }}') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

        

        :root {
            --yellow: #f1c40f;
            --ink: #0f0f0f;
            --muted: #666;
            --line: #111;
            --soft: #e9e9e9;
        }

        body {
            font-family: 'Open Sans', Montserrat, sans-serif;
            color: var(--ink);
            font-size: 12px;
            line-height: 1.45;
            padding: 30px;
        }

        /* Grid (DomPDF uyumlu) */
        .row { display: table; width: 100%; table-layout: fixed; }
        .col { display: table-cell; vertical-align: top; }
        .col-left { width: 40%; padding-right: 14px; }
        .col-right { width: 60%; padding-left: 18px; border-left: 1px solid var(--line); }

        /* Üst başlık alanı */
        .top-wrap { position: relative; height: 190px; }
        .name { font-family: 'Montserrat'; font-weight: 700; font-size: 28px; letter-spacing: 1px; margin: 0; }
        .subtitle { margin-top: 6px; font-size: 12px; color: #444; max-width: 300px;}
        .line { height: 1px; background: var(--line); margin: 16px 0 0; width: 120px; }

        /* Sağdaki sarı CV kutusu + foto çerçevesi (tasarım korunuyor) */
        .cv-box { position: absolute; right: 0; top: 0; width: 50%; height: 200px; background: var(--yellow); z-index: -1; }
        .cv-text { position: absolute; right: 24px; top: 24px; font-family: 'Montserrat'; font-weight: 700; font-size: 44px; letter-spacing: 2px; color: var(--ink); }
        .photo-wrap { position: absolute; right: 50px; top: 14px; width: 165px; height: 165px; background: #fff; border: 1.5px solid #bbb; border-radius: 8px; display: flex; align-items: center; justify-content: center;position: absolute; right:20px;  }
        .photo-wrap img { max-width: 100%; max-height: 100%; border-radius: 6px; }
        .photo-ph { font-size: 12px; color: #777; display:flex; justify-content: end; margin-right: 10px; }

        /* Bölüm başlıkları */
        .section { page-break-inside: avoid; }
        .title-icon { display: inline-block; margin-right: 8px; font-weight: 700; color: var(--yellow); font-family: 'Montserrat'; }
        .section-ttl { font-family: 'Montserrat'; font-weight: 700; font-size: 14px; letter-spacing: 2px; display: inline-block; }
        .rule { height: 1px; background: var(--line); margin: 8px 0 14px; }
        .rule-soft { height: 1px; background: var(--soft); margin: 8px 0 12px; }

        /* Metin yardımcıları */
        .muted { color: var(--muted); }
        .small { font-size: 11px; }
        .kv { margin: 0 0 6px; }
        .kv b { display: inline-block; min-width: 70px; }

        /* Spacing */
        .mt-10 { margin-top: 10px }
        .mt-14 { margin-top: 14px }
        .mt-18 { margin-top: 18px }

        /* ------- EKLENEN KÜÇÜK YARDIMCI SINIFLAR ------- */
        .logo { position:absolute; left:0; top:0; }
        .logo img { height:50px; }               /* logonun boyu */
        .name-wrap { margin-top:50px; padding-top:42px; } /* isim bloğunu biraz aşağı/sağa al */
        .footer { margin-top:12px; padding-top:10px; border-top:1px solid var(--soft); color:#555; font-size:10px; }
    </style>
</head>

<body>

    <!-- ÜST BAŞLIK -->
    <div class="top-wrap">

        <!-- LOGO (sol üst) -->
        <div class="logo">
            <!-- kendi yolunu koy: images/logo.png -->
            <img src="{{ public_path('site/assets/logo.png') }}" alt="Logo" style="height:50px;">

        </div>

        <!-- İSİM BLOĞU (biraz aşağı kaydırıldı) -->
        <div class="name-wrap">
            <h1 class="name">{{ mb_strtoupper($cv->name) }}</h1>
            <div class="subtitle">
                {{ $cv->title ?? '' }}<br>
                {{ $cv->subtitle ?? '' }}
            </div>
            <div class="line"></div>
        </div>

        <!-- Fotoğraf aynı yerde kalıyor -->
        <div class="photo-wrap">
            @if (!empty($cv->photo_path))
                <img src="{{ public_path(  ltrim($cv->photo_path, '/')) }}" alt="Photo">
            @else
                <span class="photo-ph">Photo</span>
            @endif
        </div>
    </div>

    <div class="row" style="margin-top:12px;">
        <!-- SOL KOLON -->
        <div class="col col-left">
            @if (!empty($cv->career_goal))
                <div class="section">
                    <span class="title-icon">»</span><span class="section-ttl">HAKKIMDA</span>
                    <div class="rule"></div>
                    <div class="small">{{ $cv->career_goal }}</div>
                </div>
            @endif

            <div class="section mt-18">
                <span class="title-icon">»</span><span class="section-ttl">İLETİŞİM</span>
                <div class="rule"></div>
                <p class="kv"><b>Telefon:</b> {{ $cv->phone ?? '-' }}</p>
                <p class="kv"><b>E-posta:</b> {{ $cv->email ?? '-' }}</p>
                @if (!empty($cv->birth_date))
                    <p class="kv"><b>Doğum:</b> {{ \Illuminate\Support\Carbon::parse($cv->birth_date)->format('d.m.Y') }}</p>
                @endif
            </div>

            @if (!empty($cv->languages) && is_array($cv->languages))
                <div class="section mt-18">
                    <span class="title-icon">»</span><span class="section-ttl">DİLLER</span>
                    <div class="rule"></div>
                    @foreach ($cv->languages as $lang)
                        @php $name = $lang['name'] ?? ($lang['0'] ?? null); $level = $lang['level'] ?? null; @endphp
                        @if ($name || $level)
                            <div class="kv">{{ $name }} @if ($name && $level) — @endif {{ $level }}</div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <!-- SAĞ KOLON -->
        <div class="col col-right">
            @if (!empty($cv->education) && is_array($cv->education))
                <div class="section">
                    <span class="title-icon">»</span><span class="section-ttl">EĞİTİM</span>
                    <div class="rule"></div>
                    @foreach ($cv->education as $edu)
                        @php $school = $edu['school'] ?? null; $dept = $edu['department'] ?? null; $year = $edu['year'] ?? null; @endphp
                        @if ($school || $dept || $year)
                            <div class="kv">
                                <b>{{ $school }}</b>
                                @if ($dept) — {{ $dept }} @endif
                                @if ($year) <span class="muted small"> • {{ $year }}</span> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if (!empty($cv->certificates) && is_array($cv->certificates))
                <div class="section mt-18">
                    <span class="title-icon">»</span><span class="section-ttl">SERTİFİKALAR</span>
                    <div class="rule"></div>
                    @foreach ($cv->certificates as $cert)
                        @php $cname = $cert['name'] ?? null; $cyear = $cert['year'] ?? null; @endphp
                        @if ($cname || $cyear)
                            <div class="kv">{{ $cname }} @if ($cyear) <span class="muted small">({{ $cyear }})</span> @endif</div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if (!empty($cv->experience) && is_array($cv->experience))
                <div class="section mt-18">
                    <span class="title-icon">»</span><span class="section-ttl">İŞ TECRÜBELERİ</span>
                    <div class="rule"></div>
                    @foreach ($cv->experience as $exp)
                        @php
                            $company = $exp['company'] ?? null;
                            $position = $exp['position'] ?? null;
                            $year = $exp['year'] ?? null;
                            $desc = $exp['desc'] ?? null;
                        @endphp
                        @if ($company || $position || $year || $desc)
                            <div class="kv">
                                <b>{{ $company }}</b> @if ($position) — {{ $position }} @endif
                                @if ($year) <span class="muted small"> • {{ $year }}</span> @endif
                            </div>
                            @if ($desc) <div class="small" style="margin:4px 0 10px">{{ $desc }}</div> @endif
                        @endif
                    @endforeach
                </div>
            @endif

            @if (!empty($cv->hobbies))
                <div class="section mt-18">
                    <span class="title-icon">»</span><span class="section-ttl">HOBİLER / İLGİ ALANLARI</span>
                    <div class="rule"></div>
                    <div class="small">{{ $cv->hobbies }}</div>
                </div>
            @endif

            @if (!empty(trim($cv->references ?? '')))
                <div class="section mt-18">
                    <span class="title-icon">»</span><span class="section-ttl">REFERANSLAR</span>
                    <div class="rule"></div>
                    @php $refs = preg_split('/\r\n|\r|\n/', trim($cv->references)); @endphp
                    <ul style="margin:0; padding-left:16px;">
                        @foreach ($refs as $r)
                            @if (strlen(trim($r))) <li style="margin-bottom:6px;">{{ trim($r) }}</li> @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- FOOTER -->
   <div class="footer" style="line-height:1.2;">
    <strong>ardasevinc.com.tr</strong> üzerinde {{ now()->year }} yılında hazırlanmıştır. 
    Bu CV şablonu; herkesin hızlı ve kaliteli bir özgeçmiş oluşturabilmesi için ücretsiz paylaşılmaktadır. 
    Öğrencilerin ve genç geliştiricilerin iş ve staj başvurularında öne çıkmasına yardımcı olması amaçlanmıştır. 
    Kaynak gösterilerek kişisel kullanımda serbesttir. Geri bildirimleriniz için <em>ardasevinc.com.tr</em> üzerinden ulaşabilirsiniz.
</div>

</body>
</html>
