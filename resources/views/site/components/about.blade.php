@if($about)
<a href="{{ route('site.about') }}" class="mil-about-link-wrapper" style="display: block; color: inherit; text-decoration: none;">
    <div class="mil-p-160-100">
        <div class="container">
            <div class="row mil-jcb">
                <div class="col-12">
                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">{{$about?->top_title}}</p>
                </div>
                <div class="col-lg-4">
                    <h2 class="mil-head1 mil-mb60 mil-up">{{ $about?->title }} <span class="mil-a2"></span></h2>
                    <p class="mil-text-sm mil-deco-text mil-mb60 mil-up">
                        {!! Str::limit(strip_tags($about?->desc1),200) !!}
                    </p>
                </div>
                <div class="col-lg-7">
                    <p class="mil-text-md mil-mb30 mil-up">{!! $about?->desc2 !!}</p>
                </div>
            </div>
        </div>
    </div>
</a>
@endif
