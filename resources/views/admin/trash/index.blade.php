@extends('layouts.admin')
@section('main')
<div class="mb-3">
    <div class="container-fluid">
        @forelse($pages AS $page)
            <div class="row mb-2 border rounded p-2">
                <div class="col">{{ $page->slug }}</div>
                <div class="col col-auto"><a href="{{ route('trash.restore', $page) }}" class="btn btn-outline-primary btn-sm">Restore</a></div>
                <div class="col col-auto"><a href="{{ route('trash.destroy', $page) }}" class="btn btn-outline-danger btn-sm">Delete</a></div>
            </div>
        @empty
            <div class="row mb-2 border rounded p-2">There are currently no pages in the trash.</div>
        @endforelse
    </div>
   
</div>
@endsection
