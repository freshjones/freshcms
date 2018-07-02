@extends('themes.base')
@section('body')
  <div class="p-3">
    <h1 class="mb-4">Create Billboard</h1>
    <div class="row">
      <div class="col">
        <form method="POST" action="{{ route('billboard-store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="page" value="{{ $page->id }}">
          <input type="hidden" name="id" value="{{ $id }}">
          <div class="form-group">
            <label for="content">Display</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" id="display_no" value="0" >
              <label class="form-check-label" for="display_no">No</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" id="display_yes" value="1" >
              <label class="form-check-label" for="display_yes">Yes</label>
            </div>
          </div>
          
          <div class="form-group">
            <label for="content">Admin Label</label>
            <input class="form-control" type="text" name="label" value="">
          </div>

          <div class="form-group">
            <label for="content">Heading</label>
            <input class="form-control" type="text" name="heading" value="">
          </div>

          <div class="form-group">
            <label for="content">Subheading</label>
            <input class="form-control" type="text" name="subheading" value="">
          </div>

          <div class="form-group">
            <label for="content">Link</label>
            <input class="form-control" type="text" name="link" value="">
          </div>

          <div class="form-group">
            <label for="content">Background Image</label>
            <input class="form-control-file" type="file" name="background" /><br/>
          </div>

          <div class="form-group">
            <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
