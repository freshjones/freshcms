@extends('layouts.admin')
@section('main')
<div class="mb-3">
    <a href="{{ route('redirects-create') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add Redirect</a>
</div>
<div class="mb-3">
    <div class="container-fluid">
        @forelse($redirects AS $redirect)
            <div class="row mb-2 border rounded p-2">
                <div class="col col-md-4">{{ $redirect->source_url }}</div>
                <div class="col"><a href="{{ route('redirects-edit', $redirect) }}">{{ $redirect->redirect_url }}</a></div>
                <div class="col col-auto">{{ $redirect->type }}</div>
                <div class="col col-auto"><a href="{{ route('redirects-edit', $redirect) }}" class="btn btn-outline-primary btn-sm">Edit</a></div>
                {{-- <div class="col col-auto"><a href="#" class="btn btn-outline-danger btn-sm">Delete</a></div> --}}
            </div>
        @empty
            <div class="row mb-2 border rounded p-2">There are currently no redirects.</div>
        @endforelse
    </div>
</div>
@endsection
