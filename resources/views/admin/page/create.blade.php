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
        <label for="meta_description"><span class="text-uppercase font-weight-bold text-secondary">Meta Description</span>@if($errors->first('meta_description')) <span class="text-danger">({{ $errors->first('meta_description') }})</span> @endif</label>
        <textarea name="meta_description" class="form-control @if($errors->first('meta_description')) border-danger @endif" rows="3" required>{{ old('meta_description') }}</textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ isset($buttonText) ? $buttonText : 'Create Page' }}</button>
      </div>
    </form>
  </div>
@endsection
