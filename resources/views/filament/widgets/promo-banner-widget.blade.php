<x-filament::widget>
    {{-- Ana Kart --}}
    <div class="relative overflow-hidden rounded-xl bg-[#0f1115] shadow-lg dark:border-gray-500 border-gray-800">

        {{-- 1. KATMAN: ARKA PLAN --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('site/assets/img/fa-card-bg.jpg') }}" alt="Background Pattern"
                class="h-full w-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0f1115] via-[#0f1115]/95 to-transparent/5"></div>
        </div>

        {{-- 2. KATMAN: İÇERİK --}}
        <div
            class="relative z-10 flex flex-col md:flex-row items-center justify-between px-6 py-8 md:px-10 md:py-10 lg:px-14 lg:py-12 gap-8">

            {{-- SOL TARAFI: Metinler --}}
            <div class="w-full max-w-2xl text-left">

                {{-- Başlık ve İkon --}}
                <div class="flex items-start gap-5 mb-2">


                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-white sm:text-3xl leading-tight">
                            Buradayız.
                        </h2>
                        <p class="mt-3 text-base text-gray-400 leading-relaxed max-w-lg">
                            Yeni güncelleme ve ihtiyaçlarınız için <br><strong class="text-white">Teknik Destek</strong>
                            ekibimizi arayabilirsiniz.
                        </p>
                    </div>
                </div>

                {{-- BUTON GRUBU --}}
                <div class="mt-6 flex flex-wrap gap-4 pl-[4.25rem]">

                    {{-- 1. BUTON (Primary): İstenilen Renk #17252C --}}
                    {{-- 'ring-1 ring-white/10': Butonun koyu zeminde sınırlarını belli eder --}}
                    <a href="mailto:info@selquor.com"
                        class="relative inline-flex items-center justify-center rounded-lg px-6 py-3 text-sm font-bold shadow-lg transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-cyan-900/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-gray-900"
                        style="background-color: #5BEB00; border: 1px solid #000; color:#333; !important;">
                        E-posta Gönderin
                        {{-- Hover Efekti için Parlama --}}
                        <div class="absolute inset-0 rounded-lg ring-1 ring-inset ring-white/10"></div>
                    </a>

                    {{-- 2. BUTON (Secondary): Outline & Arrow Slide --}}
                    {{-- 'group': Hover tetikleyicisi --}}
                    <a href="tel:+905326379944"
                        class="group inline-flex items-center justify-center rounded-lg border border-gray-700 bg-white/5 px-6 py-3 text-sm font-medium text-gray-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900 hover:text-white hover:border-gray-600 hover:bg-gray-800">
                        <span>Hemen Arayın</span>
                        {{-- Ok İkonu: Hover olunca sağa kayar --}}
                        <span class="ml-2 transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    </a>
                </div>
            </div>

            {{-- SAĞ TARAFI: Görsel --}}
            <div class="hidden lg:block relative shrink-0">
                <img src="{{ asset('site/assets/img/selquor-logo.svg') }}"
                    class="h-[180px] w-auto rotate-[-6deg] opacity-90 drop-shadow-2xl" alt="Logo Preview"
                    style="height:90px;">
            </div>

        </div>
    </div>
</x-filament::widget>
