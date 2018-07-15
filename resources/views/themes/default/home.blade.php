@extends('layouts.app')
@section('body')

  <div class="border-bottom">
    <div class="container d-flex justify-content-end">
      <ul class="list-unstyled d-flex m-0 p-0">
        <li class="p-1"><a class="text-dark" href="tel:(413) 475-1810">(413) 475-1810</a></li>
        <li class="p-1"><a class="text-dark" href="mailto:hello@freshjones.com">hello@freshjones.com</a></li>
        @guest
        <li class="p-1"><a class="text-dark" href="{{ route('login') }}">login</a></li>
        @endguest
      </ul>
    </div>
  </div>
  <div class="border-bottom bg-white sticky-top">
    <div class="container">
      <div class=" navbar navbar-expand-lg navbar-light mx-0 px-0">
        <h5 class="navbar-brand m-0 p-0">{{ config('settings.company', 'Fresh CMS') }}</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <span class="navbar-text mr-auto px-2 d-none d-lg-block">
            {{ config('settings.tagline', '') }}
          </span>
          @include('themes.default._nav')
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    @foreach ($pages as $page)
      <h2><a href="/{{ $page->slug }}">{{ $page->title }}</a></h2>
      <p>{{ $page->meta_description }}</p>
    @endforeach
  </div>

@endsection
