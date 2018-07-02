@extends('themes.base')
@section('body')
  <div class="py-3">
    <h1>Content Section</h1>
    <form method="POST" action="{{ route('section-store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="page" value="{{ $page->id }}">
      <input type="hidden" name="slug" value="{{ $page->slug }}">
      <input type="hidden" name="type" value="{{ $content['type'] }}">
      <input type="hidden" name="id" value="{{ $content['id'] }}">
      <input type="hidden" name="style" value="{{ $content['style'] }}">
      <input type="hidden" name="order" value="{{ $content['order'] }}">
      <div class="form-group">
        <label for="content">Display</label>
        <input type="radio" value="0" name="display" />Yes
        <input type="radio" value="1" name="display" />No
      </div>
      <div class="form-group">
        <label for="content">Label</label>
        <input type="text" name="label" value="{{ old('label', $content['label']) }}">
      </div>
      <div class="form-group">
        <label for="content">Content</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $data['description']) }}</textarea>
      </div>
      <input type="file" name="photos[]" multiple /><br/>
      <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
    </form>
  </div>
@endsection
