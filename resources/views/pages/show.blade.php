@extends('layouts.app')
@section('content')
<main role="main" class="">
   {{ $page->slug }}
   @foreach($page->contents AS $content)
   {{ $content->title }}
   {{ $content->meta_description }}
   @endforeach
</main>
@endsection
