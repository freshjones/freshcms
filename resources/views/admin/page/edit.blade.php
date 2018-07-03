@extends('layouts.app')
@section('body')
  <div class="container-fluid">
    <div class="row flex-row-reverse">
      <div class="col m-4">
        <form method="POST" action="{{ route('page-update', $page->slug) }}">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <input type="hidden" name="lang" value="en">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter a Title" value="{{ old('title', $page->title) }}" required />
            <small id="titleHelp" class="form-text text-muted">Enter a title for your page</small>
          </div>
          <div class="form-group">
            <label for="slug">URL</label>
            <input type="text" name="slug" class="form-control" placeholder="Enter a URL" value="{{ old('slug', $page->slug) }}" required />
            <small id="slugHelp" class="form-text text-muted">Enter a URL for this page</small>
          </div>
          <div class="form-group">
            <label for="meta_description">Description</label>
            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-success">Update Page</button>
          </div>
        </form>
      </div>
      <div class="col-md-8 m-4">
        <div class="container">
          <div class="row">

            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="btn-group">
                    <button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add New Section
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('billboard-create', $page->id) }}">Add Billboard</a>
                      <a class="dropdown-item" href="{{ route('content-create', $page->id) }}">Add Content</a>
                      {{-- <a class="dropdown-item" href="{{ route('section-create', [$page->id,'banner']) }}">Add Banners</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'feature']) }}">Add Features</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'post']) }}">Add Posts</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'testimonial']) }}">Add Testimonials</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'faq']) }}">Add FAQs</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'collection']) }}">Add Collection</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'profile']) }}">Add Profile</a>
                      <a class="dropdown-item" href="{{ route('section-create', [$page->id,'casestudy']) }}">Add Case Study</a> --}}
                    </div>
                  </div>
                </div>
              </div>

              @if($contents)
              <div class="row mt-2">
                <div class="col">
                  <Sections :page="{{ $page->id }}" />
                </div>
              </div>
            </div>
            @endif
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
