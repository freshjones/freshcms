@extends('layouts.app')
@section('body')
  <div class="p-3">
    <h1 class="mb-4">Billboard Section</h1>
    <div class="row">
      <div class="col-md-4">
        <form method="POST" id="billboard-form" action="{{ route('billboard-update', [$page->id,$id]) }}">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <input type="hidden" name="page" value="{{ $page->id }}">
          <input type="hidden" name="slug" value="{{ $page->slug }}">
          <input type="hidden" name="type" value="billboard">
          <input type="hidden" name="id" value="{{ $content['id'] }}">
          <input type="hidden" name="style" value="{{ $content['style'] }}">
          <input type="hidden" name="order" value="{{ $content['order'] }}">
          <div class="form-group">
            <label for="content">Display</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" id="display_no" value="0" @if ( old('display', $content['display']) == 0) checked @endif>
              <label class="form-check-label" for="display_no">No</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" id="display_yes" value="1" @if ( old('display', $content['display']) == 1) checked @endif>
              <label class="form-check-label" for="display_yes">Yes</label>
            </div>
          </div>
          <div class="form-group">
            <label for="content">Admin Label</label>
            <input class="form-control" type="text" name="label" value="{{ old('label', $content['label']) }}">
          </div>
          <div class="form-group">
            <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
            <a 
              class="btn btn-outline-danger" 
              href="{{ route('billboard-destroy', [$page->id,$id]) }}" 
              onclick="event.preventDefault(); document.getElementById('destroy-section-form').submit();" role="button">Delete</a>
          </div>
        </form>
      </div>
      <div class="col">
        <Billboards page="{{ $page->id }}" section="{{ $id }}" ></Billboards>
        <form id="destroy-section-form" action="{{ route('billboard-destroy', [$page->id,$id]) }}" method="POST" style="display: none;">
            <input name="_method" type="hidden" value="DELETE">
            @csrf
        </form>
      </div>
    </div>

  </div>
@endsection
