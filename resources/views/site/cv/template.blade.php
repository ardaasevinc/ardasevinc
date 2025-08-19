<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>{{ $cv->name }} - CV</title>
    <style>
        /* PDF için sade, A4'e uygun stil */
        @page {
            margin: 28mm 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            font-size: 12px;
            line-height: 1.45;
        }

        h1,
        h2,
        h3 {
            margin: 0 0 8px;
        }

        h1 {
            font-size: 22px;
        }

        h2 {
            font-size: 14px;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 6px;
            margin-top: 18px;
        }

        .muted {
            color: #666;
        }

        .row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .col {
            display: table-cell;
            vertical-align: top;
        }

        .col-3 {
            width: 30%;
            padding-right: 14px;
        }

        .col-9 {
            width: 70%;
            padding-left: 14px;
            border-left: 1px solid #f0f0f0;
        }

        .avatar {
            width: 100%;
            max-width: 140px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .mb-4 {
            margin-bottom: 14px;
        }

        .mb-6 {
            margin-bottom: 18px;
        }

        .list {
            margin: 0;
            padding-left: 16px;
        }

        .item {
            margin-bottom: 8px;
        }

        .kv {
            margin: 0 0 4px;
        }

        .kv b {
            display: inline-block;
            min-width: 86px;
        }

        .chip {
            display: inline-block;
            border: 1px solid #ddd;
            border-radius: 16px;
            padding: 3px 10px;
            margin: 2px 6px 2px 0;
            font-size: 11px;
        }

        .small {
            font-size: 11px;
        }

        .section {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- Üst Başlık --}}
    <div class="mb-6">
        <h1>{{ $cv->name }}</h1>
        <div class="muted small">
            @if($cv->email) {{ $cv->email }} @endif
            @if($cv->email && $cv->phone) • @endif
            @if($cv->phone) {{ $cv->phone }} @endif
            @if($cv->birth_date) • Doğum Tarihi:
            {{ \Illuminate\Support\Carbon::parse($cv->birth_date)->format('d.m.Y') }} @endif
        </div>
    </div>

    <div class="row">
        {{-- Sol Kolon: Foto + İletişim --}}
        <div class="col col-3">
            @if(!empty($cv->photo_path))
                {{-- DomPDF yerel dosya yolunu destekler --}}
                <img class="avatar mb-6" src="{{ public_path('public/' . ltrim($cv->photo_path, '/')) }}" alt="Fotoğraf">
            @endif

            <div class="section">
                <h2>İletişim</h2>
                <p class="kv"><b>E-posta:</b> {{ $cv->email ?? '-' }}</p>
                <p class="kv"><b>Telefon:</b> {{ $cv->phone ?? '-' }}</p>
                @if($cv->birth_date)
                    <p class="kv"><b>Doğum:</b> {{ \Illuminate\Support\Carbon::parse($cv->birth_date)->format('d.m.Y') }}
                    </p>
                @endif
            </div>

            @if(!empty($cv->languages) && is_array($cv->languages))
                <div class="section">
                    <h2>Diller</h2>
                    @foreach($cv->languages as $lang)
                        @php
                            $name = $lang['name'] ?? null;
                            $level = $lang['level'] ?? null;
                        @endphp
                        @if($name || $level)
                            <div class="item">{{ $name }} @if($name && $level) — @endif {{ $level }}</div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if(!empty($cv->certificates) && is_array($cv->certificates))
                <div class="section">
                    <h2>Sertifikalar</h2>
                    @foreach($cv->certificates as $cert)
                        @php
                            $cname = $cert['name'] ?? null;
                            $cyear = $cert['year'] ?? null;
                        @endphp
                        @if($cname || $cyear)
                            <div class="item">{{ $cname }} @if($cname && $cyear) ({{ $cyear }}) @elseif($cyear) {{ $cyear }} @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Sağ Kolon: Hakkında, Deneyim, Eğitim vs. --}}
        <div class="col col-9">
            @if(!empty($cv->career_goal))
                <div class="section">
                    <h2>Hakkımda / Kariyer Hedefi</h2>
                    <p>{{ $cv->career_goal }}</p>
                </div>
            @endif

            @if(!empty($cv->experience) && is_array($cv->experience))
                <div class="section">
                    <h2>İş Deneyimi</h2>
                    @foreach($cv->experience as $exp)
                        @php
                            $company = $exp['company'] ?? null;
                            $position = $exp['position'] ?? null;
                            $year = $exp['year'] ?? null;
                            $desc = $exp['desc'] ?? null;
                        @endphp
                        @if($company || $position || $year || $desc)
                            <div class="item">
                                <b>{{ $position ?? 'Pozisyon' }}</b> @if($position && $company) — @endif {{ $company }}
                                @if($year) <span class="muted small">• {{ $year }}</span> @endif
                                @if($desc)
                                    <div class="small" style="margin-top:4px;">{{ $desc }}</div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if(!empty($cv->education) && is_array($cv->education))
                <div class="section">
                    <h2>Eğitim</h2>
                    @foreach($cv->education as $edu)
                        @php
                            $school = $edu['school'] ?? null;
                            $dept = $edu['department'] ?? null;
                            $year = $edu['year'] ?? null;
                        @endphp
                        @if($school || $dept || $year)
                            <div class="item">
                                <b>{{ $school }}</b>
                                @if($dept) — {{ $dept }} @endif
                                @if($year) <span class="muted small">• {{ $year }}</span> @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if(!empty($cv->hobbies))
                <div class="section">
                    <h2>Hobiler / İlgi Alanları</h2>
                    <p>{{ $cv->hobbies }}</p>
                </div>
            @endif

            @if(!empty($cv->references))
                <div class="section">
                    <h2>Referanslar</h2>
                    {{-- Çok satırlıysa satırlara bölüp madde madde gösterelim --}}
                    @php
                        $refs = preg_split('/\r\n|\r|\n/', trim($cv->references));
                    @endphp
                    <ul class="list">
                        @foreach($refs as $r)
                            @if(strlen(trim($r)))
                            <li>{{ trim($r) }}</li> @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>

</html>