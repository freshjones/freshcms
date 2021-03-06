@extends('layouts.app')

@section('title', 'Page Not Found')

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
        <h5 class="navbar-brand m-0 p-0">Company name</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <span class="navbar-text mr-auto px-2 d-none d-lg-block">
            Navbar text with an inline element
          </span>
          
          @include('themes.default._nav')
        
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <h1>Not Found</h1>
    <h2>{{ $exception->getMessage() }} </h2>
  </div>

@endsection

