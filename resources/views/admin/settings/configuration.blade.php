@extends('layouts.admin')
@section('main')
@if ($errors->any())
    <div class="alert alert-danger">Please Fix the Errors Below.</div>
@endif
<form name="settings-form" method="POST" action="{{ route('settings-store') }}">
    @csrf
    @foreach ($settings as $key => $value)
    <div class="form-group">
        <label for="field-{{ $key }}"><span class="text-uppercase font-weight-bold color-gray">{{ $key }}</span>@if($errors->first($key)) <span class="text-danger">({{ $errors->first($key) }})</span> @endif</label>
        <input type="text" name="{{ $key }}" id="field-{{ $key }}" class="form-control @if($errors->first($key)) border-danger @endif" placeholder="Enter a value for {{ $key }}" value="{{ old($key, $value)  }}">
        <small id="{{ $key }}-help" class="form-text text-muted">Enter a value for {{ $key }}</small>
    </div>
    @endforeach
    <div>
        <button type="submit" class="btn btn-primary">Update Settings</button>
    </div>
</form>
@endsection
