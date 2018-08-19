@extends('layouts.admin')
@section('main')
<div>
    <h1>Create Redirect</h1>
    @if ($errors->any())
    <div class="alert alert-danger">Please Fix the Errors Below.</div>
    @endif
    <form method="POST" action="{{ route('redirects-store') }}">
        @csrf
        <div class="form-group">
            <label for="source_url"><span class="text-uppercase font-weight-bold text-secondary">Source URL</span>@if($errors->first('source_url')) <span class="text-danger">({{ $errors->first('source_url') }})</span>@endif</label>
            <div class="d-flex align-items-center ">
                <div class="col col-auto pr-0 ">
                    {{ url('/') }}/
                </div>
                <div class="col pl-1">
                    <input type="text" name="source_url" class="form-control @if($errors->first('source_url')) border-danger @endif" placeholder="Enter a Source URL" value="{{ old('source_url') }}"  required/>
                </div>
            </div>
            <small id="sourceHelp" class="form-text text-muted">Enter a source url</small>
        </div>
        <div class="form-group">
            <label for="redirect_url"><span class="text-uppercase font-weight-bold text-secondary">Redirect URL</span>@if($errors->first('redirect_url')) <span class="text-danger">({{ $errors->first('redirect_url') }})</span>@endif</label>
            <input type="text" name="redirect_url" class="form-control @if($errors->first('redirect_url')) border-danger @endif" placeholder="Enter a Redirect URL" value="{{ old('redirect_url') }}"  required/>
            <small id="redirectHelp" class="form-text text-muted">Enter a redirect URL</small>
        </div>
        <div class="form-group">
            <label for="type"><span class="text-uppercase font-weight-bold text-secondary">Redirect Type</span>@if($errors->first('type')) <span class="text-danger">({{ $errors->first('type') }})</span> @endif</label>
            <select class="form-control" name="type">
              <option value="301" selected>301 (Moved Permanently)</option>
              <option value="302">302 (Found)</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Redirect</button>
        </div>
    </form>
</div>
@endsection
