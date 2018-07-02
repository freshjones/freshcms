@extends('themes.base')
@section('body')
  
  <div class="py-3">
    <form method="POST" action="{{ route('page-store') }}">
      @csrf
      @include('admin.page._form')
    </form>
  </div>
@endsection
