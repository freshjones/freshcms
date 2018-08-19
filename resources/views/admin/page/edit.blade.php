@extends('layouts.app')
@section('body')
  <div class="container-fluid">
    <div class="row flex-row-reverse">
      <div class="col m-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Revisions</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <form method="POST" action="{{ route('page-update', $page->page->slug) }}">
              <input name="_method" type="hidden" value="PATCH">
              @csrf
              <input type="hidden" name="lang" value="en">
              <div class="form-group">
                <label for="title"><span class="text-uppercase font-weight-bold text-secondary">Title</span>@if($errors->first('title')) <span class="text-danger">({{ $errors->first('title') }})</span>@endif</label>
                <input type="text" name="title" class="form-control @if($errors->first('title')) border-danger @endif" placeholder="Enter a Title" value="{{ old('title', $page->title) }}"  />
                <small id="titleHelp" class="form-text text-muted">Enter a title for your page</small>
              </div>
              <div class="form-group">
                <label for="slug"><span class="text-uppercase font-weight-bold text-secondary">URL</span>@if($errors->first('slug')) <span class="text-danger">({{ $errors->first('slug') }})</span>@endif</label>
                <input type="text" name="slug" class="form-control @if($errors->first('slug')) border-danger @endif" placeholder="Enter a URL" value="{{ old('slug', $page->page->slug) }}"  />
                <small id="slugHelp" class="form-text text-muted">Enter a URL for this page</small>
              </div>

              <div class="form-group">
                <div class="form-row">
                  <div class="col">
                    <label for="publish_at"><span class="text-uppercase font-weight-bold text-secondary">Publish</span>@if($errors->first('publish_at')) <span class="text-danger">({{ $errors->first('publish_at') }})</span>@endif</label>
                    <input type="date" name="publish_at" id="publish_at" class="form-control @if($errors->first('publish_at')) border-danger @endif" value="{{ old('publish_at', $page->page->publish_at) }}"  />
                    <small id="publishAtHelp" class="form-text text-muted">Schedule a publish date</small>
                  </div>
                  <div class="col">
                    <label for="unpublish_at"><span class="text-uppercase font-weight-bold text-secondary">Unpublish</span>@if($errors->first('unpublish_at')) <span class="text-danger">({{ $errors->first('unpublish_at') }})</span>@endif</label>
                    <input type="date" name="unpublish_at" id="unpublish_at" class="form-control @if($errors->first('unpublish_at')) border-danger @endif" value="{{ old('unpublish_at', $page->page->unpublish_at) }}"  />
                    <small id="unpublishAtHelp" class="form-text text-muted">Schedule an unpublish date</small>
                  </div>
                </div>
              </div>
             
              <div class="form-group">
                <label for="meta_description"><span class="text-uppercase font-weight-bold text-secondary">Meta Description</span>@if($errors->first('meta_description')) <span class="text-danger">({{ $errors->first('meta_description') }})</span> @endif</label>
                <textarea name="meta_description" class="form-control @if($errors->first('meta_description')) border-danger @endif" rows="3" >{{ old('meta_description', $page->meta_description) }}</textarea>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-success">Update Page</button>
                <a 
                  href="javascript:void(0);" 
                  onClick="event.preventDefault(); document.getElementById('delete-page-form').submit();" 
                  class="btn btn-outline-danger">Delete</a>
              </div>
            </form>
            <form method="post" name="delete-page-form" id="delete-page-form" action="{{ route('page.delete', $page->id) }}">
              @method('DELETE')
              @csrf
            </form>
          </div>
          <div class="tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              @forelse($page->revisions AS $revision)
                  <div class="row mb-2 border rounded p-2">
                    <div class="col p-0">{{ $revision->title }}</div>
                    <div class="col col-auto p-0"><a href="{{ route('content-revert', [$page, $revision]) }}" class="btn btn-outline-secondary btn-sm">Revert</a></div>
                  </div>
              @empty
                  <div class="row mb-2 border rounded p-2">There are currently no revisions.</div>
              @endforelse

          </div>
        </div>
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
