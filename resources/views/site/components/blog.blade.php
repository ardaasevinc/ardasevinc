<!-- blog -->
<div class="mil-p-160-160">
    <div class="container">
        <div class="row mil-aie mil-mb30">
            <div class="col-md-6">
                <p class="mil-stylized mil-m2 mil-mb60 mil-up">HABERLER</p>
                <h2 class="mil-head1 mil-mb60 mil-up">EN YENİ <span class="mil-a2">HABERLER</span>
                </h2>
            </div>
            <div class="col-md-6">
                <p class="mil-stylized mil-m1 mil-tar mil-768-tal mil-mb60 mil-up">
                    {{-- <a href="#" class="mil-arrow-link mil-c-gone">Tüm Haberler</a></p> --}}
            </div>
        </div>
        <div class="swiper-container mil-blog-slider">
            <div class="swiper-wrapper mil-c-swipe mil-c-light">


                @foreach($blog as $item)

                    <div class="swiper-slide">
                        <div class="mil-blog-card">
                            <div class="mil-cover mil-up">
                                <div class="mil-hover-frame">
                                    @if(!empty($item->img1))
                                        <img src="{{ asset('uploads/' . $item->img1) }}" alt="cover" class="mil-scale-img"
                                            data-value-1="1.15" data-value-2="1">
                                    @else
                                        <img src="{{ asset('uploads/default.jpg') }}" alt="cover" class="mil-scale-img">
                                    @endif
                                </div>
                                <div class="mil-badges">
                                    <div class="mil-category">{{ $item->category->name ?? 'Kategori Yok' }}</div>
                                    <div class="mil-date">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('site.blog.detail', ['slug' => $item->slug]) }}" class="mil-descr mil-c-gone">
                                <div class="mil-text-frame">
                                    <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">
                                        {{ $item->title ?? 'Başlık Yok' }}
                                    </h4>
                                    <p class="mil-text-md mil-max-2row-text mil-up">
                                        {!! Str::limit(strip_tags($item->desc) ?? 'Açıklama mevcut değil.', 250) !!}
                                    </p>
                                </div>
                                <div class="mil-up mil-768-gone">
                                    <div class="mil-stylized-btn">
                                        <i class="fal fa-arrow-up"></i>
                                        <span>Daha Fazlası</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach





            </div>
        </div>
    </div>
</div>
<!-- blog end -->