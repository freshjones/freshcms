@extends('layouts.admin')
@section('main')
  <div >
    <h1>Create Page</h1>
    @if ($errors->any())
      <div class="alert alert-danger">Please Fix the Errors Below.</div>
    @endif
    <form method="POST" action="{{ route('page-store') }}">
      @csrf
      <input type="hidden" name="lang" value="en">
      <div class="form-group">
        <label for="title"><span class="text-uppercase font-weight-bold text-secondary">Title</span>@if($errors->first('title')) <span class="text-danger">({{ $errors->first('title') }})</span>@endif</label>
        <input type="text" name="title" class="form-control @if($errors->first('title')) border-danger @endif" placeholder="Enter a Title" value="{{ old('title') }}"  required/>
        <small id="titleHelp" class="form-text text-muted">Enter a title for your page</small>
      </div>
      <div class="form-group">
        <label for="slug"><span class="text-uppercase font-weight-bold text-secondary">URL</span>@if($errors->first('slug')) <span class="text-danger">({{ $errors->first('slug') }})</span>@endif</label>
        <input type="text" name="slug" class="form-control @if($errors->first('slug')) border-danger @endif" placeholder="Enter a URL" value="{{ old('slug') }}"  required/>
        <small id="slugHelp" class="form-text text-muted">Enter a URL for this page</small>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <label for="publish_at"><span class="text-uppercase font-weight-bold text-secondary">Publish</span>@if($errors->first('publish_at')) <span class="text-danger">({{ $errors->first('publish_at') }})</span>@endif</label>
            <input type="date" name="publish_at" id="publish_at" class="form-control @if($errors->first('publish_at')) border-danger @endif" value="{{ old('publish_at') }}"  />
            <small id="publishAtHelp" class="form-text text-muted">Schedule a publish date</small>
          </div>
          <div class="col">
            <label for="unpublish_at"><span class="text-uppercase font-weight-bold text-secondary">Unpublish</span>@if($errors->first('unpublish_at')) <span class="text-danger">({{ $errors->first('unpublish_at') }})</span>@endif</label>
            <input type="date" name="unpublish_at" id="unpublish_at" class="form-control @if($errors->first('unpublish_at')) border-danger @endif" value="{{ old('unpublish_at') }}"  />
            <small id="unpublishAtHelp" class="form-text text-muted">Schedule an unpublish date</small>
          </div>
        </div>
      </div>


      <div class="form-group">
        <label for="meta_description"><span class="text-uppercase font-weight-bold text-secondary">Meta Description</span>@if($errors->first('meta_description')) <span class="text-danger">({{ $errors->first('meta_description') }})</span> @endif</label>
        <textarea name="meta_description" class="form-control @if($errors->first('meta_description')) border-danger @endif" rows="3" required>{{ old('meta_description') }}</textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ isset($buttonText) ? $buttonText : 'Create Page' }}</button>
      </div>
    </form>
  </div>
@endsection
