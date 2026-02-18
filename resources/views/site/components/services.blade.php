@if($service->count()> 0)

<!-- services -->
<div class="">
    <div class="container">
        <div class="row mil-jcb">
            <div class="col-12">
                <p class="mil-stylized mil-m2 mil-mb60 mil-up">HİZMETLERİMİZ</p>
                <h2 class="mil-head1 mil-mb90 mil-up">BENZERSİZ <span class="mil-a1">FİKİRLER</span> ÜRETİYORUZ</h2>

            </div>
            <div class="col-lg-7">
                <ul class="mil-services-list mil-mb160">

                    @foreach($service as $item)
                        <li class="mil-service-item mil-768-mb60 mil-up">
                            <div class="mil-item-text mil-mb30">
                                <h3 class="mil-head3 mil-mb30 mil-up">{{$item->title}}</h3>
                                <p class="mil-text-md mil-deco-text mil-max-3row-text mil-up">
                                    {!! Str::limit(strip_tags($item->desc), 300) !!}
                                </p>


                            </div>
                            <div class="mil-mb30 mil-up">
                                <a href="{{ route('site.services.detail', ['slug' => $item->slug]) }}"
                                    class="mil-stylized-btn mil-c-gone">
                                    <i class="fal fa-arrow-up"></i>
                                    <span>Daha Fazlası</span>
                                </a>
                            </div>
                        </li>
                    @endforeach


                </ul>
            </div>
            <div class="col-lg-3 mil-mb130">
                <div class="row">

                @foreach ($exp as $item)
                    
                    <div class="col-md-4 col-lg-12">
                        <div class="mil-counter-item mil-mb30 mil-768-mb60 mil-up">
                        @if(!empty($item->number))
                            <h4 class="mil-offset-number mil-up">{{$item->number}}<span class="mil-a2">+</span></h4>
                            @endif
                            @if(!empty($item->number_title))
                            <div class="mil-counter-text">
                                <h5 class="mil-head4 mil-m1 mil-up">{{$item->number_title}}</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                

                </div>
            </div>
        </div>
    </div>
</div>
<!-- services end -->
@endif