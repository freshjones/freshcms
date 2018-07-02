@extends('layouts.app')
@section('content')
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    @include('admin.nav')
  </nav>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    @yield('main')
  </main>
@endsection
