@extends('layouts.site')

@section('content')
   @include('site.components.hero')
   @include('site.components.about')
   @include('site.components.iconboxes')
   @include('site.components.services')
   @include('site.components.calltoaction')
   @include('site.components.blog', ['blog' => $blog])
   @include('site.components.subscribe')
   

@endsection
