@extends('layouts.app')
@section('body')

  <div class="border-bottom">
    <div class="container d-flex justify-content-end">
      <ul class="list-unstyled d-flex m-0 p-0">
        <li class="p-1"><a class="text-dark" href="tel:(413) 475-1810">(413) 475-1810</a></li>
        <li class="p-1"><a class="text-dark" href="mailto:hello@freshjones.com">hello@freshjones.com</a></li>
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
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarSolutions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Solutions</a>
              <div class="dropdown-menu" aria-labelledby="navbarSolutions">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarServices" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Services</a>
              <div class="dropdown-menu" aria-labelledby="navbarServices">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Open Y</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div >
      {!! $body !!}
  </div>

@endsection
