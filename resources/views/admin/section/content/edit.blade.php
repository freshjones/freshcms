@extends('layouts.app')
@section('body')
<div class="container-fluid">
    <div class="py-3">
        <h1>Content Section</h1>
        <form method="POST" action="{{ route('content-update', [$page->id,$id]) }}" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <input type="hidden" name="page" value="{{ $page->id }}">
            <input type="hidden" name="slug" value="{{ $page->slug }}">
            <input type="hidden" name="type" value="{{ $content['type'] }}">
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
                <label for="title"><span class="text-uppercase font-weight-bold text-secondary">Label</span>@if($errors->first('label')) <span class="text-danger">({{ $errors->first('label') }})</span>@endif</label>
                <input type="text" class="form-control @if($errors->first('label')) border-danger @endif" name="label" value="{{ old('label', $content['label']) }}">
            </div>
            <div class="form-group">
                <label for="description"><span class="text-uppercase font-weight-bold text-secondary">Content</span></label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $data['description']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="file"><span class="text-uppercase font-weight-bold text-secondary">Files</span></label>
                <input type="file" class="form-control" name="photos[]" multiple /><br/>
            </div>
            <div class="form-group">
                <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
                <a 
                class="btn btn-outline-danger" 
                href="{{ route('content-destroy', [$page->id,$id]) }}" 
                onclick="event.preventDefault(); document.getElementById('destroy-section-form').submit();" role="button">Delete</a>
            </div>
        </form>
        <form id="destroy-section-form" action="{{ route('content-destroy', [$page->id,$id]) }}" method="POST" style="display: none;">
            <input name="_method" type="hidden" value="DELETE">
            @csrf
        </form>
    </div>
</div>
@endsection
