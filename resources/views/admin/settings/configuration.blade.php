@extends('layouts.admin')
@section('main')
<form name="settings-form" method="POST" action="{{ route('settings-store') }}">
    @csrf
    @foreach ($vars as $var)
    <div class="form-group">
        <label for="field-{{ $var->name }}" class="text-uppercase font-weight-bold color-gray">{{ $var->name }}</label>
        <input type="text" name="{{ $var->name }}" id="field-{{ $var->name }}" class="form-control" placeholder="Enter a {{ $var->name }}" value="{{ old($var->name, $var->value)  }}">
        <small id="{{ $var->name }}-help" class="form-text text-muted">Enter a value for {{ $var->name }}</small>
    </div>
    @endforeach
    <div>
        <button type="submit" class="btn btn-primary">Update Settings</button>
    </div>
</form>
@endsection
