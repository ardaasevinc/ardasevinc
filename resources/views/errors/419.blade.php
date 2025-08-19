@extends('layouts.site')
@section('content')

   <!-- page transition -->
   <div class="mil-transition-fade" id="swup">
  <div class="mil-transition-frame">

  <!-- content -->
  <div id="smooth-content" class="mil-content">

  <!-- hero -->
  <div class="mil-hero-1 mil-up" id="top">
  <div class="container mil-hero-main mil-relative mil-aic">
   <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
   <div class="mil-text-pad"></div>
   <i class="far fa-poop mil-mb15"></i>
   <p class="mil-stylized mil-m2 mil-mb50">oops!</p>
   <div class="mil-word-frame mil-mb30">
   <h1 class="mil-display2 mil-rubber">Hay Aksi! <span class="mil-a2">419</span></h1>
   <div class="mil-s-4"><img src="{{asset('site/assets/img/shapes/4.png')}}" alt="shape"></div>
   </div>
   <h1 class="mil-head2 mil-m3 mil-rubber mil-mb50">birşeyler hatalı gitti galiba.</h1>
   <a href="{{route('site.index')}}" class="mil-btn mil-btn-border mil-c-gone">anasayfaya geri dön</a>
   </div>
   <div class="mil-shapes mil-scale-img" data-value-1=".7" data-value-2="1.11">
   <div class="mil-s-1"><img src="{{asset('site/assets/img/shapes/1.png')}}" alt="shape"></div>
   <div class="mil-s-2"><img src="{{asset('site/assets/img/shapes/2.png')}}" alt="shape"></div>
   <div class="mil-s-3"><img src="{{asset('site/assets/img/shapes/3.png')}}" alt="shape"></div>
   </div>
  </div>
  </div>
  <!-- hero end -->


  </div>
  <!-- content -->

  </div>
   </div>
   <!-- page transition -->





@endsection